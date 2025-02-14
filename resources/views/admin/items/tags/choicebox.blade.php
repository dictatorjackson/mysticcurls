<h3>Choices</h3>

<p>These are the rewards that the user will have the option to choose from when they use the box from their inventory. Each row will be one option; to include a "bundle", select an item with the normal box tag containing multiple rewards. The box will only distribute rewards to the user themselves - character-only currencies should not be added.</p>

@include('widgets._loot_select', ['loots' => $tag->getData(), 'showLootTables' => true, 'showRaffles' => true])
