<div>
    {{-- Do your work, then step back. --}}
    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                snap.pay(@this.snapToken, {
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        @this.berhasil()
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log(result)
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        @this.gagal()
                    }
                });
            })
        </script>
    @endpush
</div>
