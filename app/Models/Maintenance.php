<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'uuid',
        'logo',
        'logo_url',
        'header_label',
        'header_bg_image',
        'header_bg_image_url',
        'branch_title',
        'branch_subtitle',
        'service_title',
        'service_subtitle',
        'about_img',
        'about_title',
        'about_subtitle',
        'about_description',
        'contact_address_labe',
        'contact_mobile_number',
        'contact_availability',
        'contact_email',
        'contact_email_details',
        'footer_description',
        'footer_twitter_url',
        'footer_facebook_url',
        'footer_instagram_url',
        'footer_manual_link',
        'footer_privacy_link'
    ];

    public function user() {

        return $this->BelongsTo(User::class);
    }
}
