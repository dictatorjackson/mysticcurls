<li class="list-group-item">
    <a class="card-title h5 collapse-title"  data-toggle="collapse" href="#openChoiceBoxForm"> Open Choice Box</a>
    <div id="openChoiceBoxForm" class="collapse">
        {!! Form::hidden('tag', $tag->tag) !!}
        <p>This item has a selection of prizes inside, but you can only choose one! Please note that you can only select one choice each time you open this box, so if you have multiple and want different choices, you should open them one at a time. This action is not reversible. Are you sure you want to open this box?</p>
        @php
            // Format information for reward selection
            // This is a little messy, but works nicely within the modular format of an
            // item tag, and for this particular purpose
            $rewardOptions = [];
            foreach($tag->data as $type=>$group) {
                switch($type) {
                    case 'items':
                        foreach($group as $id=>$quantity) {
                            $item = App\Models\Item\Item::where('id', $id)->first();
                            $rewardOptions['Items'][$type.'-'.$id] = $item->name.' x'.$quantity;
                        }
                        break;
                    case 'currencies':
                        foreach($group as $id=>$quantity) {
                            $currency = App\Models\Currency\Currency::where('id', $id)->first();
                            $rewardOptions['Currencies'][$type.'-'.$id] =  $currency->name.' x'.$quantity;
                        }
                        break;
                    case 'raffle_tickets':
                        foreach($group as $id=>$quantity) {
                            $raffle = App\Models\Raffle\Raffle::where('id', $id)->first();
                            $rewardOptions['Raffle Tickets'][$type.'-'.$id] = nl2br(htmlentities($raffle->displayName)).' x'.$quantity;
                        }
                        break;
                    case 'loot_tables':
                        foreach($group as $id=>$quantity) {
                            $lootTable = App\Models\Loot\LootTable::where('id', $id)->first();
                            $rewardOptions['Loot Tables'][$type.'-'.$id] = $lootTable->getRawOriginal('display_name').' x'.$quantity.' (This reward is random)';
                        }
                        break;
                }
            }
        @endphp

        <div class="form-group">
            {!! Form::select('choicebox_reward', $rewardOptions, null, ['class' => 'form-control choiceBox', 'placeholder' => 'Select a Reward']) !!}
        </div>
        <script>
            $(document).ready(function() {
                $('.choiceBox').selectize({
                    sortField: "text",
                });
            });
        </script>
        <div class="text-right">
            {!! Form::button('Open', ['class' => 'btn btn-primary', 'name' => 'action', 'value' => 'act', 'type' => 'submit']) !!}
        </div>
    </div>
</li>
