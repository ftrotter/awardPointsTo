<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <div class="min-vh-100 bg-light">
        <div class="container">
            <header class="row py-4">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">
                    <img src="/images/wizard_logo_120x120.png" alt="Wizard Logo" style="width: 240px; height: 240px;" />
                </div>
                <div class="col-md-4">
                    <nav v-if="canLogin" class="d-flex justify-content-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="btn btn-outline-primary mx-2"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="btn btn-outline-primary mx-2"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="btn btn-outline-primary mx-2"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </div>
            </header>

            <main class="container py-4">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center mb-4">Award Points To ----</h1>
                        <h3 class="text-center mb-4">Family and Friends Beta</h3>
                        
                        <div class="card">
                            <div class="card-body">
                                <p>An Application to use ChatGPT as a front-end for a "award point to this house/team" interface.</p>
                                <p>Obvious Homage (while being different enough to be clearly Fair Use) to the Xarry Xotter franchise!!
                                This is not that though!</p>
                                
                                <p class="mb-3">Important differences:</p>
                                <ul style="list-style-type: disc; padding-left: 2rem;">
                                    <li class="mb-2">Primary mode supports working together to get the total as high as possible. Houses/Teams are not strictly in competition.</li>
                                    <li class="mb-2">Track points based on person, across houses/teams, as opposed to having persons associated with one and only one team.</li>
                                    <li class="mb-2">Teams/Houses are designed get points when an individual does something that supports the house ideals, or lose points for violating the house ideals.</li>
                                    <li class="mb-2">Obviously you can setup your houses to map to Xogwarts.. but you can also do Xedi vs Xith or model out a point system for whatever your favorite mythical world</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="text-center py-4">
                <a href="/privacy" class="text-decoration-none">Privacy Policy</a>
            </footer>
        </div>
    </div>
</template>
