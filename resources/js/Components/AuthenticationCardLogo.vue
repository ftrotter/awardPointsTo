<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <img 
            src="/images/wizard_logo_120x120.png" 
            alt="Wizard Logo" 
            style="width: 4rem; height: 4rem; object-fit: contain;"
        />
    </Link>
</template>
