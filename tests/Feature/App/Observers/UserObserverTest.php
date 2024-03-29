<?php

namespace Tests\Feature\App\Observers;

use App\Models\Entrant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserObserverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function testEntrantIsCreated()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->assertSame(1, $user->entrants->count());
        /** @var Entrant $firstEntrant */
        $firstEntrant = $user->entrants->first();
        $this->assertSame($user->first_name, $firstEntrant->first_name);
        $this->assertSame($user->last_name, $firstEntrant->family_name);
        $this->assertSame($user->can_retain_data, $firstEntrant->can_retain_data);
    }
}
