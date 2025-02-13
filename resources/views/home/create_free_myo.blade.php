@extends('home.layout')

@section('home-title') Free MYO @endsection

@section('home-content')
    {!! breadcrumbs(['Characters' => 'characters', 'My MYO Slots' => 'myos', 'Create Free MYO' => 'new']) !!}

<h1>
        Create Free MYO 
</h1>

@if($closed)
    <div class="alert alert-danger">
        Free MYO slots are currently closed. You cannot make a new MYO slot at this time.
    </div>
@elseif($hasMaxNumber && Auth::user()->settings->free_myos_made >= $maxNumber)
    <div class="alert alert-danger">
        You have reached the limit of free MYO slots you can create. If you believe this to be an error, please contact a moderator.
    </div>
@elseif($hasInactiveMyo)
    <div class="alert alert-danger">
        You currently have an <a href="{{ url('myo/'.$inactiveMyoId->first()) }}">un-used free MYO slot</a>. Please submit a design request before creating a new slot.
    </div>
@else 
{!! Form::open(['url' => 'characters/myos/new', 'id' => 'submissionForm']) !!}
    {{ Form::hidden('name', 'Free MYO') }}

    <!-- Editable via Site Settings -->
    {{ Form::hidden('is_giftable', $isGiftable ? 1 : null) }}
    {{ Form::hidden('is_tradeable', $isTradeable ? 1 : null) }}
    {{ Form::hidden('is_sellable', $isResellable ? 1 : null) }}
    {{ Form::hidden('rarity_id', $hasRarity != 0 ? $rarity : null) }}
    @if($hasSpeciesUsable)
        <div class="form-group">
            {!! Form::label('Species') !!}{!! add_help('This will select the specific species your MYO will be. Leave it blank if you would like to choose later.') !!}
            {!! Form::select('species_id', $specieses, old('species_id'), ['class' => 'form-control', 'id' => 'species']) !!}
        </div>
        @if($hasSubtypeUsable)
            <div class="form-group" id="subtypes">
                {!! Form::label('Subtype (Optional)') !!}{!! add_help('This will lock the slot into a particular subtype. Leave it blank if you would like to choose later. The subtype must match the species selected above, and if no species is specified, the subtype will not be applied.') !!}
                {!! Form::select('subtype_id', $subtypes, old('subtype_id'), ['class' => 'form-control disabled', 'id' => 'subtype']) !!}
            </div>
        @else
            <p class="alert alert-danger">No subtypes are currently available to use for free MYOs.</p>
        @endif
    @else
        {{ Form::hidden('species_id', null) }}
        {{ Form::hidden('subtype_id', null) }}
    @endif
    
    <!-- Null $data Values -->
    {{ Form::hidden('user_id', Auth::user()->id) }}
    {{ Form::hidden('owner_url', null) }}
    {{ Form::hidden('description', null) }}
    {{ Form::hidden('is_visible', 1) }}
    {{ Form::hidden('designer_id[]', null) }}
    {{ Form::hidden('designer_url[]', null) }}
    {{ Form::hidden('artist_id[]', null) }}
    {{ Form::hidden('artist_url[]', null) }}
    {{ Form::hidden('feature_id[]', null) }}
    {{ Form::hidden('feature_data[]', null) }}

    <div class="text-center">
        <a href="#" class="btn btn-primary" id="submitButton">Create Free MYO</a>
    </div>
{!! Form::close() !!}
@endif

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title h5 mb-0">Confirm  Creation</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>This will create a free MYO slot. You cannot make a new one until a design request(s) are submitted for the current one(s) in your possession
                    @if($hasMaxNumber)
                        ,and you can only make a maximum of $maxNumber free slots
                    @endif
                . Do you wish to continue?</p>
                <div class="text-right">
                    <a href="#" id="formSubmit" class="btn btn-primary">Confirm</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent 
    <script>
    $( "#species" ).change(function() {
      var species = $('#species').val();
      var myo = '<?php echo($isMyo); ?>';
      $.ajax({
        type: "GET", url: "{{ url('characters/check-subtype') }}?species="+species+"&myo="+myo, dataType: "text"
      }).done(function (res) { $("#subtypes").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
    });

        $(document).ready(function() {
            var $submitButton = $('#submitButton');
            var $confirmationModal = $('#confirmationModal');
            var $formSubmit = $('#formSubmit');
            var $submissionForm = $('#submissionForm');
            
            $submitButton.on('click', function(e) {
                e.preventDefault();
                $confirmationModal.modal('show');
            });

            $formSubmit.on('click', function(e) {
                e.preventDefault();
                $submissionForm.submit();
            });
        });
    </script>
@endsection