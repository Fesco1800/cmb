<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

use App\Models\Maintenance;
use App\Models\LandingPageService;
class MaintenanceController extends Controller
{
    
    public function index() {
        if (auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning', 'Unauthorized action.');
        }

        $details = Maintenance::query()
        ->with('user')
        ->first();

        return view('admin.maintenance.index', [
            'details' => $details,
            'services' => LandingPageService::all()
        ]);
    }

    public function header(Request $request) {
        $uuid = $request->uuid ?? Str::random(16);
        $logo = null; $logo_url = null;
        $background_image = null; $background_image_url = null;

        // $header = Maintenance::findOrCreate(array('uuid' => $uuid));
        // $header->uuid = $uuid;
        // $header->header_label = $request->header_label;

        if (!$this->find()) {
            $header = new Maintenance();
        }

        else {
            $header = Maintenance::where('uuid', $uuid)
            ->first();
        }

        if ($request->hasFile('logo')) {
            $image = $request->logo;
            $logo = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/maintenance'),$logo);
            $logo_url = URL::to('/images/maintenance/'.$logo);

            $header->logo = $logo;
            $header->logo_url = $logo_url;
        }

        if ($request->hasFile('header_bg_image')) {
            $image = $request->header_bg_image;
            $background_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/maintenance'),$background_image);
            $background_image_url = URL::to('/images/maintenance/'.$background_image);
            
            $header->header_bg_image = $background_image;
            $header->header_bg_image_url = $background_image_url;
        }

        $header->uuid = $uuid;
        $header->header_label = $request->header_label;
        $header->user_id = auth()->user()->id;
        $header->save();

        return redirect()->back()->with('message','Header successfully updated');
    }

    public function branch(Request $request) {
        $uuid = $request->uuid ?? Str::random(16);

        if (!$this->find()) {
            $branch = new Maintenance();
        }

        else {
            $branch = Maintenance::where('uuid', $uuid)
            ->first();
        }

        $branch->branch_title = $request->branch_title;
        $branch->branch_subtitle = $request->branch_subtitle;
        $branch->save();

        return redirect()->back()->with('message','Branch successfully updated');
    }

    public function service(Request $request) {
        $uuid = $request->uuid ?? Str::random(16);

        if (!$this->find()) {
            $service = new Maintenance();
        }

        else {
            $service = Maintenance::where('uuid', $uuid)
            ->first();
        }

        $service->service_title = $request->service_title;
        $service->service_subtitle = $request->service_subtitle;
        $service->save();

        return redirect()->back()->with('message','Service successfully updated');
    }

    public function about(Request $request) {

        $uuid = $request->uuid ?? Str::random(16);

        if (!$this->find()) {
            $about = new Maintenance();
        }

        else {
            $about = Maintenance::where('uuid', $uuid)
            ->first();
        }

        if ($request->hasFile('about_img')) {
            $image = $request->about_img;
            $about_img = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/maintenance/about'),$about_img);
            $img_url = URL::to('/images/maintenance/about/'.$about_img);

            $about->about_img = $img_url;
        }

        $about->about_title = $request->about_title;
        $about->about_subtitle = $request->about_subtitle;
        $about->about_description = $request->about_description;
        $about->save();

        return redirect()->back()->with('message','About successfully updated');
    }

    public function contact(Request $request) {
        
        $uuid = $request->uuid ?? Str::random(16);

        if (!$this->find()) {
            $contact = new Maintenance();
        }

        else {
            $contact = Maintenance::where('uuid', $uuid)
            ->first();
        }

        $contact->contact_address_label = $request->contact_address_label;
        $contact->contact_address_details = $request->contact_address_details;
        $contact->contact_mobile_number = $request->contact_mobile_number;
        $contact->contact_availability = $request->contact_availability;
        $contact->contact_email = $request->contact_email;
        $contact->contact_email_details = $request->contact_email_details;
        $contact->save();

        return redirect()->back()->with('message','Contact successfully updated');
    }

    public function footer(Request $request) {
        
        $uuid = $request->uuid ?? Str::random(16);

        if (!$this->find()) {
            $footer = new Maintenance();
        }

        else {
            $footer = Maintenance::where('uuid', $uuid)
            ->first();
        }

        $footer->footer_description = $request->footer_description;
        $footer->footer_twitter_url = $request->footer_twitter_url;
        $footer->footer_facebook_url = $request->footer_facebook_url;
        $footer->footer_instagram_url = $request->footer_instagram_url;
        $footer->footer_manual_link = $request->footer_manual_link;
        $footer->footer_privacy_link = $request->footer_privacy_link;
        $footer->save();

        return redirect()->back()->with('message','Footer successfully updated');
    }

    public function announcement(Request $request) {

        $uuid = $request->uuid ?? Str::random(16);

        if (!$this->find()) {
            $announcement = new Maintenance();
        }

        else {
            $announcement = Maintenance::where('uuid', $uuid)
            ->first();
        }

        if ($request->hasFile('announcement_img')) {
            
            $image = $request->announcement_img;
            $announcement_img = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/maintenance'),$announcement_img);

            $announcement->announcement_img = $announcement_img;
        }

        $announcement->announcement_title = $request->announcement_title;
        $announcement->announcement_description = $request->announcement_description;
        $announcement->save();

        return redirect()->back()->with('message','Announcement successfully updated');

    }

    public function find() {
        $find = Maintenance::first();

        if ($find == null) {
            return false;
        }

        return true;
    }
}
