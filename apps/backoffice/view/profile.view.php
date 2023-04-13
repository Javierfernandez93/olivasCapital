<div id="app">
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('../../src/img/trading.webp'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl avatar-editable overflow-hidden img-upload position-relative" @click="openFileManager">
                        <img :src="user.image" :alt="user.name" class="w-100 border-radius-lg shadow-sm">
                        <input class="d-none" ref="file" @change="uploadFile($event)" capture="filesystem" type="file"
                            accept=".jpg, .png, .jpeg" />
                    </div>
                </div>
                <div class="col my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ user.names }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ user.email }}
                        </p>
                    </div>
                </div>
                <div class="col-auto my-auto text-end">
                    <div class="text-muted fw-semibold small">Estatus</div>
                    <div>
                        <span 
                            v-if="user.plan"
                            class="badge bg-primary">
                            Activo en PLAN {{user.plan.name}}
                        </span>
                        <span v-else
                            class="badge bg-secondary">
                            Usuario inactivo
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row mb-3">
            <div class="col-12 col-xl-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Configuración de plataforma</h6>
                    </div>
                    <div class="card-body p-3">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder">Referidos</h6>
                        <ul class="list-group">
                            <li class="list-group-item border-0 px-0">
                                <div class="form-check form-switch ps-0">
                                    <input class="form-check-input ms-auto" type="checkbox" id="referral_email" v-model="user.referral_email">
                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="referral_email">Recibir email cuando se unen a mi grupo</label>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-check form-switch ps-0">
                                    <input class="form-check-input ms-auto" type="checkbox" id="referral_notification" v-model="user.referral_notification">
                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="referral_notification">Recibir notificaciones cuando se unen a mi grupo</label>
                                </div>
                            </li>
                        </ul>
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mt-4">Cuenta</h6>
                        <ul class="list-group">
                            <li class="list-group-item border-0 px-0">
                                <div class="form-check form-switch ps-0">
                                    <input class="form-check-input ms-auto" type="checkbox" id="info_email" v-model="user.info_email">
                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="info_email">Recibir correos electrónicos con información</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0">Información de perfil</h6>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="javascript:;">
                                    <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip"
                                        data-bs-placement="top" aria-hidden="true" aria-label="Edit Profile"></i><span
                                        class="sr-only">Edit Profile</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <label>ID de afiliado</label>
                                <input type="text" readonly v-model="user.company_id" disabled class="form-control" placeholder="Email"/>
                            </li>

                            <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                <label>Nombre</label>
                                <input type="text" v-model="user.names" class="form-control" placeholder="Nombre"/>
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <label>Teléfono</label>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-select" v-model="user.country_id" aria-label="Selecciona tu país">
                                            <option>Selecciona tu país</option>
                                            <option v-for="country in countries" v-bind:value="country.country_id">
                                                {{ country.nicename }} <span v-if="country.phone_code > 0">+ {{ country.phone_code }}</span>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <input type="text" v-model="user.phone" ref="phone" class="form-control" placeholder="Celular"/> 
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <label>Correo electrónico</label>
                                <input type="text" v-model="user.email" :disabled="true" class="form-control" placeholder="Email"/>
                            </li>
                            <li 
                                v-if="user.referral"
                                class="list-group-item border-0 ps-0 text-sm">
                                <label clas="mb-3">Patrocinador</label>
                                <div class="row align-items-center px-3">
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <img :src="user.referral.image" class="border-radius-lg shadow"/>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-0 text-sm">
                                            {{user.referral.names}}
                                        </h6>
                                        <p class="mb-0 text-xs">{{user.referral.email}}</p>
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge bg-primary">ID {{user.referral.user_login_id}} </span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0">Últimos referidos</h6>
                            </div>
                            <div v-if="lastReferrals.length > 0" class="col-auto">
                                <span class="badge bg-secondary">Cantidad {{lastReferrals.length}}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="lastReferrals.length > 0"
                        class="card-body p-4">
                        <ul class="list-group">
                            <li v-for="lastReferral of lastReferrals" class="list-group-item border-0 px-0 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <img :src="lastReferral.image" alt="kal"
                                                class="border-radius-lg shadow">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-0 text-sm">{{lastReferral.names}}</h6>
                                        <p class="mb-0 text-xs">Miembro desde {{lastReferral.signup_date}}</p>
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge bg-primary">ID {{lastReferral.user_login_id}}</span>
                                    </div>
                                </li>
                            </li>
                        </ul>
                    </div>
                    <div v-else class="card-body">
                        <div class="text-center">
                            No tenemos información de tus últimos referidos, si aún no has invitado a unirse a tu grupo puedes hacerlo desde tu <a class="fw-semibold" href="../../apps/backoffice"><u>Oficina virtual</u></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-none">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-xl-6 mb-xl-0 mb-4">
                        <div class="card bg-transparent shadow-xl">
                            <div class="overflow-hidden position-relative border-radius-xl"
                                style="background-image: url('../../src/img/curved-images/curved14.jpg');">
                                <span class="mask bg-gradient-dark"></span>
                                <div class="card-body position-relative z-index-1 p-3">
                                    <i class="fas fa-wifi text-white p-2" aria-hidden="true"></i>
                                    <h5 class="text-white mt-4 mb-5 pb-2">
                                        4562&nbsp;&nbsp;&nbsp;1122&nbsp;&nbsp;&nbsp;4594&nbsp;&nbsp;&nbsp;7852</h5>
                                    <div class="d-flex">
                                        <div class="d-flex">
                                            <div class="me-4">
                                                <p class="text-white text-sm opacity-8 mb-0">Card Holder</p>
                                                <h6 class="text-white mb-0">Jack Peterson</h6>
                                            </div>
                                            <div>
                                                <p class="text-white text-sm opacity-8 mb-0">Expires</p>
                                                <h6 class="text-white mb-0">11/22</h6>
                                            </div>
                                        </div>
                                        <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                                            <img class="w-60 mt-2" src="../../src/img/logos/mastercard.png" alt="logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header mx-4 p-3 text-center">
                                        <div
                                            class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                            <i class="fas fa-landmark opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 p-3 text-center">
                                        <h6 class="text-center mb-0">Salary</h6>
                                        <span class="text-xs">Belong Interactive</span>
                                        <hr class="horizontal dark my-3">
                                        <h5 class="mb-0">+$2000</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-0 mt-4">
                                <div class="card">
                                    <div class="card-header mx-4 p-3 text-center">
                                        <div
                                            class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                            <i class="fab fa-paypal opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 p-3 text-center">
                                        <h6 class="text-center mb-0">Paypal</h6>
                                        <span class="text-xs">Freelance Payment</span>
                                        <hr class="horizontal dark my-3">
                                        <h5 class="mb-0">$455.00</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-lg-0 mb-4">
                        <div class="card mt-4">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center">
                                        <h6 class="mb-0">Payment Method</h6>
                                    </div>
                                    <div class="col-6 text-end">
                                        <a class="btn bg-gradient-dark mb-0" href="javascript:;"><i class="fas fa-plus"
                                                aria-hidden="true"></i>&nbsp;&nbsp;Add New Card</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-md-6 mb-md-0 mb-4">
                                        <div
                                            class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                            <img class="w-10 me-3 mb-0" src="../../src/img/logos/mastercard.png"
                                                alt="logo">
                                            <h6 class="mb-0">
                                                ****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;7852
                                            </h6>
                                            <i class="fas fa-pencil-alt ms-auto text-dark cursor-pointer"
                                                data-bs-toggle="tooltip" data-bs-placement="top" aria-hidden="true"
                                                aria-label="Edit Card"></i><span class="sr-only">Edit Card</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                            <img class="w-10 me-3 mb-0" src="../../src/img/logos/visa.png" alt="logo">
                                            <h6 class="mb-0">
                                                ****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;5248
                                            </h6>
                                            <i class="fas fa-pencil-alt ms-auto text-dark cursor-pointer"
                                                data-bs-toggle="tooltip" data-bs-placement="top" aria-hidden="true"
                                                aria-label="Edit Card"></i><span class="sr-only">Edit Card</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">Invoices</h6>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn btn-outline-primary btn-sm mb-0">View All</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 pb-0">
                        <ul class="list-group">
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">March, 01, 2020</h6>
                                    <span class="text-xs">#MS-415646</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $180
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="fas fa-file-pdf text-lg me-1" aria-hidden="true"></i> PDF</button>
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="text-dark mb-1 font-weight-bold text-sm">February, 10, 2021</h6>
                                    <span class="text-xs">#RV-126749</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $250
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="fas fa-file-pdf text-lg me-1" aria-hidden="true"></i> PDF</button>
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="text-dark mb-1 font-weight-bold text-sm">April, 05, 2020</h6>
                                    <span class="text-xs">#FB-212562</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $560
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="fas fa-file-pdf text-lg me-1" aria-hidden="true"></i> PDF</button>
                                </div>
                            </li>
                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="text-dark mb-1 font-weight-bold text-sm">June, 25, 2019</h6>
                                    <span class="text-xs">#QW-103578</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $120
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="fas fa-file-pdf text-lg me-1" aria-hidden="true"></i> PDF</button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="text-dark mb-1 font-weight-bold text-sm">March, 01, 2019</h6>
                                    <span class="text-xs">#AR-803481</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    $300
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                            class="fas fa-file-pdf text-lg me-1" aria-hidden="true"></i> PDF</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <iframe src="https://trade.mql5.com/trade?servers=SomeBroker1-Demo,SomeBroker1-Live,SomeBroker2-Demo,SomeBroker2-Live&trade_server=SomeBroker-Demo&startup_mode=open_demo&lang=es&save_password=off"allowfullscreen="allowfullscreen" style="width: 100%; height: 100%; border: none;" class="vh-100"></iframe> -->
