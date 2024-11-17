<template>
    <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center py-4 bg-light">
        <div>
            <slot name="logo" />
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm mt-4">
                        <div class="card-body">
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
