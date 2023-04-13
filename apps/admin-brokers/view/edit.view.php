<div class="container-fluid py-4" id="app">
    <div class="card">
        <div class="card-header pb-0 px-3"> 
            <h6 class="mb-0">Editar broker</h6>
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
                    @keydown.enter.exact.prevent="updateBroker"
                    ref="fee"
                    type="text" class="form-control" placeholder="0%">
            </div>
        
            <button 
                :disabled="!brokerComplete"
                ref="button"
                type="submit" class="btn btn-primary" @click="updateBroker">Actualizar broker</button>
        </div>
    </div>
</div>