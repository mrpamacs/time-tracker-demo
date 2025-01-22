<div class="flex flex-col gap-4 justify-items-center">
    <div class="flex flex-col text-xl justify-center py-4 font-bold items-center">Track Time Exports</div>
    <div class="flex flex-row gap-8 items-end">
        <x-mary-datepicker label="From" wire:model.defer="dateFrom" icon="o-calendar" :config="['altFormat' => 'Y-m-d']"/>
        <x-mary-datepicker label="To" wire:model.defer="dateTo" icon="o-calendar" :config="['altFormat' => 'Y-m-d']"/>
        <div>
            <x-mary-button type="button" label="Export" class="btn-success" wire:click="export"></x-mary-button>
        </div>
    </div>
</div>