<div class="container-fluid py-4" id="app">

    <div class="alert alert-info text-white">
        <div class="row d-flex align-items-center">
            <div class="col">
                <strong>Aviso</strong>
                <div class="fw-semibold fs-6">Ya puedes añadir capital a tu cuenta con coinpayments.net</div>
            </div>
            <div class="col-auto">
                <a href="../../apps/wallet/addFunds" class="btn btn-light">Añadir fondos</a>
            </div>
        </div>
    </div>

    <profit-viewer></profit-viewer>

    <div class="row">
        <div class="col-lg-5">
            <div class="card h-100 p-3 overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../../src/img/ivancik.jpg');">
                <span class="mask bg-gradient-dark"></span>
                <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                    <h5 class="text-white font-weight-bolder">Haz crecer tu grupo y gana</h5>
                    <p class="text-white">Gran Capital te premia por referir usuarios activos.</p>
                    
                    <div v-if="landing">
                        <div class="mb-3">
                            <div class="text-light">Link personalizado</div>
                            <div>
                                <a class="text-white" :href="landing">{{landing}}</a>
                            </div>
                        </div>

                        <button class="btn btn-primary" ref="landing" :data-text="landing" data-helper="Link de landing copiada" @click="copyLanding">
                            Copiar Landing Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <notice-viewer></notice-viewer>
</div>