<div class="container-fluid py-4" id="app">
    <div class="card">
        <div class="card-header pb-0 px-3"> 
            <h6 class="mb-0">Añadir broker</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label>Broker</label>
                <input 
                    :autofocus="true"
                    :class="broker.name ? 'is-valid' : ''"
                    @keydown.enter.exact.prevent="$refs.fee.focus()"
                    v-model="broker.name"
                    ref="name"
                    type="text" class="form-control" placeholder="nombre">
            </div>
            <div class="mb-3">
                <label>Fee</label>
                <input 
                    v-model="broker.fee"
                    :class="broker.name ? 'is-valid' : ''"
                    @keydown.enter.exact.prevent="$refs.capital.focus()"
                    ref="fee"
                    type="text" class="form-control" placeholder="0%">
            </div>
            <div class="mb-3">
                <label>Capital inicial</label>
                <input 
                    v-model="broker.capital"
                    @keydown.enter.exact.prevent="$refs.gain.focus()"
                    ref="capital"
                    type="number" class="form-control" placeholder="$0">
            </div>
            <div class="mb-3">
                <label>Ganancia inicial</label>
                <input 
                    v-model="broker.gain"
                    @keydown.enter.exact.prevent="saveBroker"
                    ref="gain"
                    type="number" class="form-control" placeholder="$0">
            </div>
        
            <button 
                :disabled="!brokerComplete"
                ref="button"
                type="submit" class="btn btn-primary" @click="saveBroker">Guardar broker</button>
        </div>
    </div>
</div>