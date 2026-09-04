<div class="flex flex-col items-center justify-center space-y-4">
    <div class="text-2xl font-bold">
        {{ $counter }}
    </div>

    <div class="flex items-center justify-center p-10 m-10">
        <button class="px-4 py-2 bg-blue-500 text-white rounded" wire:click="increment">
            +
        </button>

        <button class="px-4 py-2 bg-red-500 text-white rounded" wire:click="decrement">
            -
        </button>
    </div>
</div>