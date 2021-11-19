<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreImageRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreImageRequest $request)
    {
        $image = static::saveAndUploadImage($request->validated(), $request->file('image'));

        return redirect()->route('images.show', $image);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
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
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Image $image)
    {
        return view('image.edit', [
            'image' => $image,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImageRequest  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        if ($request->hasFile('image')) {
            $savedImage = static::saveAndUploadImage($request->validated(), $request->file('image'), $image);
        } else {
            $image->update($request->validated());
            $savedImage = $image;
        }

        return redirect()->route('images.show', $savedImage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
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

        $imgFing = imgFing();

        $imageData = getImageDataFromStorage($image);

        $image->identifier = $imgFing->identifyString($imageData);
        $image->identifier_image = $imgFing->createIdentityImageFromString($imageData);
        $image->save();

        return $image;
    }

    public static function deleteImage(Image $image)
    {
        Storage::disk('local')->delete($image->getFilePath());

        $image->delete();
    }
}
