<div x-data="{timerStarted : @entangle('timerStarted'), showModal: @entangle('showModal')}">
    <x-mary-modal wire:model="showModal" class="backdrop-blur">
        <div>

                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col justify-center items-center text-xl capitalize">{{ $selectedProject?->name }}</div>
                        <div class="flex flex-col justify-center items-center font-semibold text-3xl" id="elapsedTime">{{ $this->elapsedTimeFormatted }}</div>
                        <textarea wire:model.live.debounce.200ms="rem" class="flex flex-col justify-center items-center border"></textarea>
                    </div>
        </div>
        <x-slot:actions>
            <div class="mt-4 flex flex-row gap-8 justify-center">
                <x-mary-button label="Start" type="button" class="btn-success" wire:click="startTimer" x-bind:disabled="timerStarted"/>
                <x-mary-button label="Stop" type="button" class="btn-error" wire:click="stopTimer" x-bind:disabled="timerStarted == false"/>
            </div>
        </x-slot:actions>
    </x-mary-modal>

    @push('scripts')
        <script>
            var timeTracker = null;

            stopTimeTracker = function () {
                if (typeof timeTracker !== "undefined") {
                    clearInterval(timeTracker);
                }
            }

            window.addEventListener('timer-start', (event) => {
                stopTimeTracker()

                var elapsedTime = parseInt(event.detail[0].elapsedTime);
                timeTracker = setInterval(() => {
                    document.getElementById('elapsedTime').innerHTML = moment.utc(elapsedTime * 1000).format('HH:mm:ss');
                    elapsedTime += 1;
                }, 1000);
            });

            window.addEventListener('timer-stop', () => {
                stopTimeTracker();
            });

        </script>
    @endpush
</div>
