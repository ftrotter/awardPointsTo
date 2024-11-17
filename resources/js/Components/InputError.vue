<script setup>
defineProps({
    message: String,
});
</script>

<template>
    <div v-show="message">
        <p class="form-text text-danger small mb-0">
            {{ message }}
        </p>
    </div>
</template>
