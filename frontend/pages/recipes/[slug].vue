<script setup>
import RecipeDetails from '~/components/RecipeDetails.vue'
</script>

<template>
    <div class="p-10 space-y-10">
        <button class="text-sm text-gray-400" @click="$router.back()"> <span>&larr;</span> Back to Recipe List</button>
        <RecipeDetails />
    </div>
</template>