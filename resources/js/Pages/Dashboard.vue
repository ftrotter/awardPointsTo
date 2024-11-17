<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="h4 mb-0">
                Dashboard
            </h2>
        </template>

        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <Welcome />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
