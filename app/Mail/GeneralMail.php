<?php

namespace App\Mail;

use App\Models\SiteInformation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected array $attributes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attributes)
    {
        $this->attributes = $attributes;
        $this->afterCommit();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $socialLinks = SiteInformation::first(['facebook_url', 'instagram_url', 'linkedin_url', 'twitter_url', 'youtube_url'])->toArray();
        $this->attributes['social_links'] = $socialLinks;

        return $this->to('ashish.k@mightywarner.com')
            ->subject($this->attributes['subject'] ?? 'KN Express')
            ->view('emails.general-mail')
            ->with('attributes', $this->attributes);
    }
}
