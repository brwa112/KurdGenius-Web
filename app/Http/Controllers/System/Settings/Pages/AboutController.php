<?php

namespace App\Http\Controllers\System\Settings\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\Settings\Pages\About\UpdateAboutRequest;
use App\Http\Requests\System\Settings\Pages\About\UpdateMediaRequest;
use App\Http\Requests\System\Settings\Pages\About\UpdateMessageRequest;
use App\Http\Requests\System\Settings\Pages\About\UpdateMissionRequest;
use App\Http\Requests\System\Settings\Pages\About\UpdateTouchRequest;
use App\Models\Pages\Branch;
use App\Models\Pages\About\AboutAbout;
use App\Models\Pages\Gallery;
use App\Models\Pages\About\AboutMessage;
use App\Models\Pages\About\AboutMission;
use App\Models\Pages\About\AboutTouch;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        $branchId = $request->input('branch_id') ?? Branch::active()->ordered()->first()->id;

        $about = AboutAbout::where('branch_id', $branchId)->first();
    $media = Gallery::where('branch_id', $branchId)->first();
        $message = AboutMessage::where('branch_id', $branchId)->first();
        $mission = AboutMission::where('branch_id', $branchId)->first();
        $touch = AboutTouch::where('branch_id', $branchId)->first();

        return inertia('System/Settings/Pages/About/Index', [
            'about' => $about ? [
                'id' => $about->id,
                'description' => $about->getTranslations('description'),
                'is_active' => $about->is_active,
                'images' => $about->getMedia('images')->map->getFullUrl(),
            ] : null,
            'media' => $media ? [
                'id' => $media->id,
                'title' => $media->getTranslations('title'),
                'description' => $media->getTranslations('description'),
                'is_active' => $media->is_active,
                // Gallery model exposes images via appended attribute
                'gallery' => $media->images,
                // Videos are not part of Gallery by design
                'videos' => [],
            ] : null,
            'message' => $message ? [
                'id' => $message->id,
                'description' => $message->getTranslations('description'),
                'author' => $message->getTranslations('author'),
                'order' => $message->order ?? null,
                'is_active' => $message->is_active,
                'author_image' => $message->getFirstMediaUrl('author_image'),
            ] : null,
            'mission' => $mission ? [
                'id' => $mission->id,
                'description' => $mission->getTranslations('description'),
                'is_active' => $mission->is_active,
                'images' => $mission->getMedia('images')->map->getFullUrl(),
            ] : null,
            'touch' => $touch ? [
                'id' => $touch->id,
                'contact_email' => $touch->contact_email,
                'contact_phone' => $touch->contact_phone,
                'contact_address' => $touch->getTranslations('contact_address'),
                'is_active' => $touch->is_active,
                'images' => $touch->getMedia('images')->map->getFullUrl(),
            ] : null,
        ]);
    }

    public function updateAbout(UpdateAboutRequest $request)
    {
        $validated = $request->validated();

        $about = AboutAbout::firstOrCreate([
            'branch_id' => $request->input('branch_id'),
            'user_id' => auth()->id(),
        ], [
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'description' => $validated['description'] ?? ['en' => '', 'ckb' => ''],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        $about->update([
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'description' => $validated['description'] ?? $about->description,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        // handle images if provided
        // support both legacy multiple 'images' and new single 'image'
        if ($request->input('remove_images') || $request->input('remove_image')) {
            $about->clearMediaCollection('images');
        }

        // single image upload (new behaviour)
        if ($request->hasFile('image')) {
            $about->clearMediaCollection('images');
            // add single uploaded file to the images collection
            $about->addMediaFromRequest('image')->toMediaCollection('images');
        }

        // legacy: multiple images
        if ($request->hasFile('images')) {
            // if multiple images are uploaded, clear then add
            $about->clearMediaCollection('images');
            foreach ($request->file('images') as $file) {
                $about->addMedia($file)->toMediaCollection('images');
            }
        }

        return back()->with('success', __('system.about_section_updated'));
    }

    public function updateMedia(UpdateMediaRequest $request)
    {
        $validated = $request->validated();

        $media = Gallery::firstOrCreate([
            'branch_id' => $request->input('branch_id'),
            'user_id' => auth()->id(),
        ], [
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'title' => $validated['title'] ?? ['en' => '', 'ckb' => ''],
            'description' => $validated['description'] ?? ['en' => '', 'ckb' => ''],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        $media->update([
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'title' => $validated['title'] ?? $media->title,
            'description' => $validated['description'] ?? $media->description,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        // Images are stored in the Gallery model under 'images' collection
        if ($request->input('remove_gallery')) {
            $media->clearMediaCollection('images');
        }

        if ($request->hasFile('gallery')) {
            $media->clearMediaCollection('images');
            foreach ($request->file('gallery') as $file) {
                $media->addMedia($file)->toMediaCollection('images');
            }
        }

        return back()->with('success', __('system.media_section_updated'));
    }

    public function updateMessage(UpdateMessageRequest $request)
    {
        $validated = $request->validated();

        $message = AboutMessage::firstOrCreate([
            'branch_id' => $request->input('branch_id'),
            'user_id' => auth()->id(),
        ], [
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'description' => $validated['description'] ?? ['en' => '', 'ckb' => ''],
            'author' => $validated['author'] ?? [],
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        $message->update([
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'description' => $validated['description'] ?? $message->description,
            'author' => $validated['author'] ?? $message->author,
            'order' => $validated['order'] ?? $message->order,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        if ($request->input('remove_author_image')) {
            $message->clearMediaCollection('author_image');
        }

        if ($request->hasFile('image')) {
            $message->clearMediaCollection('author_image');
            $message->addMediaFromRequest('image')->toMediaCollection('author_image');
        }

        return back()->with('success', __('system.message_section_updated'));
    }

    public function updateMission(UpdateMissionRequest $request)
    {
        $validated = $request->validated();

        $mission = AboutMission::firstOrCreate([
            'branch_id' => $request->input('branch_id'),
            'user_id' => auth()->id(),
        ], [
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'description' => $validated['description'] ?? ['en' => '', 'ckb' => ''],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        $mission->update([
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'description' => $validated['description'] ?? $mission->description,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        // mission section has no images to handle

        return back()->with('success', __('system.mission_section_updated'));
    }

    public function updateTouch(UpdateTouchRequest $request)
    {
        $validated = $request->validated();

        $touch = AboutTouch::firstOrCreate([
            'branch_id' => $request->input('branch_id'),
            'user_id' => auth()->id(),
        ], [
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'contact_email' => $validated['contact_email'] ?? null,
            'contact_phone' => $validated['contact_phone'] ?? null,
            'contact_address' => $validated['contact_address'] ?? [],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        $touch->update([
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'contact_email' => $validated['contact_email'] ?? $touch->contact_email,
            'contact_phone' => $validated['contact_phone'] ?? $touch->contact_phone,
            'contact_address' => $validated['contact_address'] ?? $touch->contact_address,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        // touch/contact section has no images to handle

        return back()->with('success', __('system.touch_section_updated'));
    }
}
