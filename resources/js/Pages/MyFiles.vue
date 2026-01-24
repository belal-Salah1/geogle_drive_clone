<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
defineOptions({ layout: AuthenticatedLayout });

</script>

<template>
    {{ $page.url }}
</template>