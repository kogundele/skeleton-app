<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute();
const recipe = ref(null);
const loading = ref(true);
const error = ref(null);

const config = useRuntimeConfig()

const fetchRecipe = async () => {
  loading.value = true;
  error.value = null;

  try {
    const { data } = await $fetch(`${config.public.apiBase}/recipes/${route.params.slug}`);
    recipe.value = data;
  } catch (err) {
    error.value = err?.data?.message || 'Recipe not found.';
    console.log
  } finally {
    loading.value = false;
  }
};

onMounted(fetchRecipe);
</script>

<template>
    <div class="space-y-10">
      <div v-if="loading">
        Loading...
      </div>
  
      <div class="space-y-5" v-else-if="error">
        <p>Recipe Not Found</p>
        <NuxtLink class="bg-blue-500 text-white p-2 text-sm rounded" to="/">View List of Recipes</NuxtLink>
      </div>
  
      <div v-else>
        <h1 class="text-3xl font-bold">{{ recipe.name }}</h1>
        <p class="text-gray-500 mt-1">Author: {{ recipe.email }}</p>
        <p class="mt-4">{{ recipe.description }}</p>
  
        <div class="mt-6 space-y-2">
          <h2 class="text-xl font-semibold">Ingredients</h2>
          <div class="flex flex-wrap gap-2">
            <span
              class="text-sm px-4 py-1 border border-orange-500 rounded-full"
              v-for="ingredient in recipe.ingredients" :key="ingredient">
              {{ ingredient }}
            </span>
          </div>
        </div>
  
        <div class="mt-6 shadow-md border border-gray-200 p-5">
          <h2 class="text-xl font-semibold">Steps</h2>
          <ol class="list-decimal list-inside mt-2">
            <li class="text-gray-500 py-2" v-for="step in recipe.steps" :key="step">{{ step }}</li>
          </ol>
        </div>
      </div>
    </div>
</template>