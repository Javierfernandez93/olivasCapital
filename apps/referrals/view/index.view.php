<div class="container-fluid py-4" id="app">
    <div class="row">
        <div class="col-12">
            <div
                v-if="referrals.length > 0"
                class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col fw-semibold text-dark">Afiliados</div>
                        <div class="col-auto"><span class="badge bg-primary">Total de afiliados {{referrals.length}}</span></div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Monto invertido</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Miembro desde</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="referral in referrals">
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs text-secondary mb-0">{{referral.company_id}}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img :src="referral.image" class="avatar avatar-sm me-3" :alt="referral.names">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{referral.names}}</h6>
                                                <p class="text-xs text-secondary mb-0">{{referral.email}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span v-if="referral.plan"  
                                            class="badge badge-sm bg-primary small">
                                            $ {{referral.plan.ammount.numberFormat(2)}}
                                        </span>
                                        <span v-else>
                                            Sin monto
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs text-secondary mb-0">{{referral.signup_date.formatDate()}}</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td class="align-middle text-center text-sm">
                                        <h6>Total</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <h6>$ {{totals.total_capital.numberFormat(2)}}</h6>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="alert alert-secondary text-white text-center">
                    <div>No tienes afiliados, por favor comparte tu link personalizado para hacer crecer tu grupo de afiliados</div>
                    <div class="fw-semibold fs-5">Puedes encontrar tu Link personalizado en tu <a class="text-white" href="../../apps/backoffice"><u>oficina virtual</u></a></div>
                </div>
            </div>
        </div>
    </div>
</div>