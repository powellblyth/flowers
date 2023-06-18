<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use NZTim\Mailchimp\Mailchimp;
use NZTim\Mailchimp\Member;

class MailChimpService
{
    private static bool $enabled = true;

    public const MEMBERTYPE_FIELD = "MEMBERTYPE";

    // Not a typo! it really only has one E
    public const COMMITTEE_FIELD = 'ISCOMMITTE';

    public static function enable(): void
    {
        static::$enabled = true;
    }

    public static function disable(): void
    {
        static::$enabled = false;
    }

    public function __construct(
        private readonly Mailchimp $mailchimp,
        private readonly ?string $defaultListId = null,
    ) {
    }

    private function defaultList(): string
    {
        return $this->defaultListId ?? config('flowers.mailchimp.mailing_list_id');
    }

    public function subscribe(
        ?string $email,
        ?string $membership = null,
        bool $isCommittee = false,
        string $firstName = '',
        string $lastName = '',
        ?string $listId = null,
    ): void {
        if (static::$enabled) {
            $this->mailchimp->subscribe(
                $listId ?? $this->defaultList(),
                $email,
                [
                    self::MEMBERTYPE_FIELD => $membership,
                    self::COMMITTEE_FIELD => (int) $isCommittee,
                    'FNAME' => $firstName,
                    'LNAME' => $lastName,
                ],
                false,
            );
            Log::debug("subscribing");
        }
    }

    public function unsubscribe(?string $email, ?string $listId = null): void
    {
        if (static::$enabled) {
            if ($this->mailchimp->check($listId ?? $this->defaultList(), $email)) {
                // If the user is unsubscribed, we cannot add them as unsubscribed
                // so we only change them if they already exist
                $this->mailchimp->unsubscribe($listId ?? $this->defaultList(), $email);
                $this->mailchimp->archive($listId ?? $this->defaultList(), $email);
                Log::debug('unsubscribed');
            } else {
                Log::debug('Not subscribed, refusing to unsubscribe');
            }
        }
    }
}
