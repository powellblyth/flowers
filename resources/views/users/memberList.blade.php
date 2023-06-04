<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('PreviousMember List') }}
    </x-slot>
    <x-slot name="header">
        <x-headers.h1>
            {{ __('PreviousMember List') }}
        </x-headers.h1>
    </x-slot>

    <x-layout.intro-para>
        <table class="table-auto text-sm">
            <tr>
                <th class="px-4">Name</th>
                <th class="px-4">Previous Membership year</th>
                <th class="px-4">Can Retain Data?<br /><i>Please Ask</i></th>
                <th class="px-4">Can Email?<br /><i>Please Ask</i></th>
                <th class="px-4">Email Address</th>
                <th class="px-4">Renewing?</th>
            </tr>
            @foreach($members as $member)
                <tr class="border-t-2">
                    <td>{{$member->full_name}} / {{$member->postcode}}</td>
                    <td></td>
                    <td class="text-center">{!! $member->can_retain_data ? 'Yes': 'No <span class="border-4 inline-block w-12">&nbsp;</span>' !!}</td>
                    <td class="text-center">{!! $member->can_email ? 'Yes': 'No <span class="border-4 inline-block w-12">&nbsp;</span>' !!}</td>
                    <td>{{$member->email}}<br />
                        <span class="border-4 inline-block w-64">&nbsp;</span></td>
                    <td><div class="border-4 w-12">&nbsp;</div></td>
                </tr>
            @endforeach
        </table>

    </x-layout.intro-para>
</x-app-layout>
