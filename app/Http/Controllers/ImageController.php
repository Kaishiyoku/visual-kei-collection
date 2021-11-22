<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Artist;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use ImageManager;
use ImgFing;
use Intervention\Image\Constraint;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('image.index', [
            'images' => Image::orderBy('id', 'desc')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('image.create', [
            'image' => new Image(),
            'artistNames' => collect(),
            'availableArtists' => getArtistNamesForTagInput(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreImageRequest $request)
    {
        $image = static::saveAndUploadImage($request->validated(), $request->file('image'));

        static::syncArtists($request, $image);

        return redirect()->route('images.show', $image);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Image $image)
    {
        return view('image.show', [
            'image' => $image,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Image $image)
    {
        return view('image.edit', [
            'image' => $image,
            'artistNames' => $image->artists()->pluck('name'),
            'availableArtists' => getArtistNamesForTagInput(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateImageRequest $request
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        if ($request->hasFile('image')) {
            PossibleDuplicateController::deletePossibleDuplicatesForImage($image);

            $savedImage = static::saveAndUploadImage($request->validated(), $request->file('image'), $image);
        } else {
            $image->update($request->validated());
            $savedImage = $image;
        }

        static::syncArtists($request, $savedImage);

        return redirect()->route('images.show', $savedImage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Image $image)
    {
        static::deleteImage($image);

        return redirect()->route('images.index');
    }

    private static function saveAndUploadImage($validated, UploadedFile $imageFile, Image $image = null)
    {
        $fileExtension = $imageFile->getClientOriginalExtension();
        [$width, $height] = getimagesize($imageFile->getRealPath());

        $image = Image::updateOrCreate(['id' => optional($image)->id],
            array_merge($validated, [
                'file_extension' => $fileExtension,
                'mimetype' => $imageFile->getMimeType(),
                'file_size' => $imageFile->getSize(),
                'width' => $width,
                'height' => $height,
            ]));

        $imageFile->storeAs('vk', "{$image->id}.{$fileExtension}");

        $imageData = $image->getImageDataFromStorage();

        $image->identifier = ImgFing::identifyString($imageData);
        $image->identifier_image = ImgFing::createIdentityImageFromString($imageData);
        $image->save();

        static::saveThumbnail($image);

        return $image;
    }

    public static function saveThumbnail(Image $image)
    {
        $thumbnail = $image->getImageFromStorage()
            ->resize(config('visual_kei.thumbnail_max_width'), null, function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->psrResponse('jpg', config('visual_kei.thumbnail_quality'));

        Storage::disk('vk')->put("thumbnails/{$image->id}.jpg", $thumbnail->getBody()->getContents());
    }

    public static function deleteImage(Image $image)
    {
        PossibleDuplicateController::deletePossibleDuplicatesForImage($image);

        Storage::disk('vk')->delete($image->getFileName());
        Storage::disk('vk')->delete("thumbnails/{$image->getThumbnailFileName()}");

        $image->delete();
    }

    private static function syncArtists(Request $request, Image $image): void
    {
        $artistNames = collect(empty($request->get('artists')) ? [] : $request->get('artists'));

        $artistIds = $artistNames->map(function (string $artistName) {
            $artist = Artist::firstOrCreate(['name' => $artistName]);

            return $artist->id;
        });

        $image->artists()->sync($artistIds);
    }
}
