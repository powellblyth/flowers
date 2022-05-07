<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use NZTim\Mailchimp\Mailchimp;
use NZTim\Mailchimp\Member;

class MailChimpService
{
    private static $enabled = false;

    public static function enable(): void
    {
        static::$enabled = true;
    }

    public static function disable(): void
    {
        static::$enabled = false;
    }

    public function __construct(
        private         readonly Mailchimp $mailchimp,
        private ?string $defaultListId = null,
    ) {
    }

    private function defaultList(): string
    {
        return $this->defaultListId ?? config('flowers.mailchimp.mailing_list_id');
    }

    public function subscribe(?string $email, ?string $listId = null)
    {
        if (static::$enabled) {
            $member = (new Member($email))->language('en');
            $member = $member->confirm(false)->status('subscribed');
            $this->mailchimp->addUpdateMember($listId ?? $this->defaultList(), $member);
            Log::debug("subscribing");
        }
    }

    public function unsubscribe(?string $email, ?string $listId = null)
    {
        if (static::$enabled) {
            if ($this->mailchimp->check($listId ?? $this->defaultList(), $email)) {
                // If the user is unsubscribed, we cannot add them as unsubscribed
                // so we only change them if they already exist
                $this->mailchimp->unsubscribe($listId ?? $this->defaultList(), $email);
                Log::debug('unsubscribed');
            } else {
                Log::debug('Not subscribed, refusing to unsubscribe');
            }
        }
    }
}
