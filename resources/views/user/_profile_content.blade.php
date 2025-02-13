@if ($deactivated)
    <div style="filter:grayscale(1); opacity:0.75">
@endif

<div class="row pt-3 pb-3" style="border: 7px double white; border-radius: 10px;  background-image: url('{{ $user->profileImgUrl }}'); background-position: top middle; text-align: center; background-size: cover;">
    <div class="col-lg-12" style="text-shadow: 0 0 5px white ;">
        <h1>
            <div style="position: relative; margin: auto;">
                <img src="/images/avatars/{{ $user->avatar }}" style="width:125px; height:125px; border-radius:50%;" alt="{{ $user->name }}" />
            </div>
            <div style="position: relative; margin: auto;">
                {!! $user->displayName !!}
                <a href="{{ url('reports/new?url=') . $user->url }}"><i class="fas fa-exclamation-triangle fa-xs" data-toggle="tooltip" title="Click here to report this user." style="opacity: 50%; font-size:0.5em;"></i></a>
            </div>
        </h1>
        <div class="row no-gutters justify-content-center mb-5" style="background-color: rgba(255, 255, 255, .60); padding: 5px; border-radius: 10px;">
            <div class="col-md-1 text-center">
                <i class="fas fa-users"></i> {!! $user->rank->displayName !!}{!! add_help($user->rank->parsed_description) !!}
            </div>
            <div class="col-md-2 text-center">
                <i class="fas fa-link"></i>&nbsp;&nbsp;{!! $user->displayAlias !!}
            </div>
            <div class="col-md-2 text-center">
                <i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;{!! format_date($user->created_at, false) !!}
            </div>
            @if ($user->birthdayDisplay && isset($user->birthday))
                <div class="col-md-2 text-center">
                    <i class="fas fa-birthday-cake"></i> {!! $user->birthdayDisplay !!}
                </div>
            @endif
            @if ($user->settings->is_fto)
                <span class="badge badge-success" data-toggle="tooltip" title="This user has not owned any characters from this world before.">FTO</span>
            @endif
        </div>
    </div>
</div>

<br />

@if (isset($user->profile->parsed_text))
    <div class="card mb-3" style="clear:both;">
        <div class="card-body">
            {!! $user->profile->parsed_text !!}
        </div>
    </div>
@endif

<div class="card-deck mb-4 profile-assets" style="clear:both;">
    <div class="card profile-currencies profile-assets-card">
        <div class="card-body text-center">
            <h5 class="card-title">Bank</h5>
            <div class="profile-assets-content">
                @foreach ($user->getCurrencies(false) as $currency)
                    <div>{!! $currency->display($currency->quantity) !!}</div>
                @endforeach
            </div>
            <div class="text-right"><a href="{{ $user->url . '/bank' }}">View all...</a></div>
        </div>
    </div>
    <div class="card profile-inventory profile-assets-card">
        <div class="card-body text-center">
            <h5 class="card-title">Inventory</h5>
            <div class="profile-assets-content">
                @if (count($items))
                    <div class="row">
                        @foreach ($items as $item)
                            <div class="col-md-3 col-6 profile-inventory-item">
                                @if ($item->imageUrl)
                                    <img src="{{ $item->imageUrl }}" data-toggle="tooltip" title="{{ $item->name }}" alt="{{ $item->name }}" />
                                @else
                                    <p>{{ $item->name }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div>No items owned.</div>
                @endif
            </div>
            <div class="text-right"><a href="{{ $user->url . '/inventory' }}">View all...</a></div>
        </div>
    </div>
</div>

<h2>
    <a href="{{ $user->url . '/characters' }}">Characters</a>
    @if (isset($sublists) && $sublists->count() > 0)
        @foreach ($sublists as $sublist)
            / <a href="{{ $user->url . '/sublist/' . $sublist->key }}">{{ $sublist->name }}</a>
        @endforeach
    @endif
</h2>

@foreach ($characters->take(4)->get()->chunk(4) as $chunk)
    <div class="row mb-4">
        @foreach ($chunk as $character)
            <div class="col-md-3 col-6 text-center">
                <div>
                    <a href="{{ $character->url }}"><img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="{{ $character->fullName }}" /></a>
                </div>
                <div class="mt-1">
                    <a href="{{ $character->url }}" class="h5 mb-0">
                        @if (!$character->is_visible)
                            <i class="fas fa-eye-slash"></i>
                        @endif {{ Illuminate\Support\Str::limit($character->fullName, 20, $end = '...') }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endforeach

<div class="text-right"><a href="{{ $user->url . '/characters' }}">View all...</a></div>
<hr class="mb-5" />

<div class="row col-12">
    <div class="col-md-8">

        @comments(['model' => $user->profile, 'perPage' => 5])

    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Mention This User</h5>
            </div>
            <div class="card-body">
                In the rich text editor:
                <div class="alert alert-secondary">
                    {{ '@' . $user->name }}
                </div>
                @if (!config('lorekeeper.settings.wysiwyg_comments'))
                    In a comment:
                    <div class="alert alert-secondary">
                        [{{ $user->name }}]({{ $user->url }})
                    </div>
                @endif
                <hr>
                <div class="my-2"><strong>For Names and Avatars:</strong></div>
                In the rich text editor:
                <div class="alert alert-secondary">
                    {{ '%' . $user->name }}
                </div>
                @if (!config('lorekeeper.settings.wysiwyg_comments'))
                    In a comment:
                    <div class="alert alert-secondary">
                        [![{{ $user->name }}'s Avatar]({{ $user->avatarUrl }})]({{ $user->url }}) [{{ $user->name }}]({{ $user->url }})
                    </div>
                @endif
            </div>
            @if (Auth::check() && Auth::user()->isStaff)
                <div class="card-footer">
                    <h5>[ADMIN]</h5>
                    Permalinking to this user, in the rich text editor:
                    <div class="alert alert-secondary">
                        [user={{ $user->id }}]
                    </div>
                    Permalinking to this user's avatar, in the rich text editor:
                    <div class="alert alert-secondary">
                        [userav={{ $user->id }}]
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@if ($deactivated)
    </div>
@endif
