<div class="row world-entry">
    @if ($subtype->subtypeImageUrl)
        <div class="col-md-3 world-entry-image">
            <a href="{{ $subtype->subtypeImageUrl }}" data-lightbox="entry" data-title="{{ $subtype->name }}">
                <img src="{{ $subtype->subtypeImageUrl }}" class="world-entry-image" alt="{{ $subtype->name }}" />
            </a>
        </div>
    @endif
    <div class="{{ $subtype->subtypeImageUrl ? 'col-md-9' : 'col-12' }}">
        <x-admin-edit title="Subtype" :object="$subtype" />
        <h3>
            @if (!$subtype->is_visible)
                <i class="fas fa-eye-slash mr-1"></i>
            @endif
            {!! $subtype->displayName !!} ({!! $subtype->species->displayName !!} Subtype)
            <a href="{{ $subtype->searchUrl }}" class="world-entry-search text-muted">
                <i class="fas fa-search"></i>
            </a>
        </h3>
        @if($subtype->is_free_myo_usable)
            <div class="float-right m-2">
                    <span class="fa-stack fa-1x" data-toggle="tooltip" data-placement="top" title="This species can be selected for Free MYO slots!">
                        <i class="fas fa-ticket-alt fa-stack-2x"></i>
                        <i class="fas fa-gift fa-xs fa-stack-1x fa-inverse"></i>
                    </span>
            </div>
        @endif
        <h3>{!! $subtype->displayName !!} ({!! $subtype->species->displayName !!} Subtype) <a href="{{ $subtype->searchUrl }}" class="world-entry-search text-muted"><i class="fas fa-search"></i></a></h3>
        <div class="world-entry-text">
            {!! $subtype->parsed_description !!}
        </div>
    </div>
</div>
