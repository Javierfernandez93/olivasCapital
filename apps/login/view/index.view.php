<div class="row d-flex justify-content-center align-items-center vh-100" id="app">
    <div class="col-12 col-xl-6 img-bg bg-primary order-1">
        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../../src/img/business.jpg')"></div>
        </div>
    </div>
    <div class="col-11 col-xl-6 animate__animated animate__bounceInLeft">
        <div class="row justify-content-center text-center">
            <div class="col-11 col-xl-6">
                <div class="card p-3 text-start cards-plain">
                    <div class="card-header pb-0 text-left bg-transparent">
                        <h3 class="font-weight-bolder text-info text-gradient">Bienvenido de nuevo</h3>
                        <p class="mb-0">Ingresa tus datos para iniciar sesión</p>
                    </div>
                    <div class="card-body">
                        <form role="form">
                            <label>Correo electrónico</label>
                            <div class="mb-3">
                                <input 
                                    :autofocus="true"
                                    :class="isValidMail ? 'is-valid' : ''"
                                    @keydown.enter.exact.prevent="$refs.password.focus()"
                                    type="email" ref="email" v-model="user.email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                            </div>
                            <label>Contraseña</label>
                            <div class="input-group mb-3">
                                <input 
                                    :type="fieldPasswordType"
                                    :class="user.password ? 'is-valid' : ''"
                                    @keydown.enter.exact.prevent="doLogin"
                                    style="height:41px"
                                    type="password" ref="password" v-model="user.password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                <button class="btn btn-secondary" type="button" id="button-addon2" @click="toggleFieldPasswordType">
                                    <i v-if="fieldPasswordType == 'password'" class="bi bi-eye"></i>
                                    <i v-else class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" v-model="user.rememberMe" id="rememberMe" checked="">
                                        <label class="form-check-label" for="rememberMe">Recordarme</label>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <a class="small" href="../../apps/login/forgotPassword">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>

                            <div v-show="feedback" class="alert alert-secondary text-white alert-dismissible fade show" role="alert">
                                {{ feedback }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="text-center">
                                <button
                                    :disabled="!userComplete" 
                                    @click="doLogin"
                                    type="button" class="btn bg-gradient-success w-100 mt-4 mb-0">Ingresar a mi cuenta</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center pt-0 px-lg-2 px-1">
                        <p class="mb-4 text-sm mx-auto">
                            ¿No tienes una cuenta?
                            <a href="../../apps/signup" class="text-info text-gradient font-weight-bold">Regístrate aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>