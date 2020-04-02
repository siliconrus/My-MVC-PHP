<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Восстановление пароля</div>

                    <div class="card-body">
                        <form method="POST" action="/account/reset">

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"  autocomplete="email" autofocus >
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Восстановить пароль
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>


<!--                        <form method="POST" type="hidden" action="/account/reset/{token:\w+}">-->
<!---->
<!--                            <div class="form-group row">-->
<!--                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>-->
<!---->
<!--                                <div class="col-md-6">-->
<!--                                    <input id="email" type="email" class="form-control" name="email"  autocomplete="email" autofocus >-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="form-group row mb-0">-->
<!--                                <div class="col-md-8 offset-md-4">-->
<!--                                    <button type="submit" class="btn btn-primary">-->
<!--                                        Восстановить пароль-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </form>-->
                </div>
            </div>
        </div>
    </div>
</main>