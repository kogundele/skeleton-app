<script setup>
import { ref, watch, onMounted } from 'vue'

const config = useRuntimeConfig()

let search = reactive({
    keyword: null,
    email: null,
    ingredient: null
})
let pagination = reactive({
    from: null,
    to: null,
    lastPage: 1,
    currentPage: 1,
})
let recipes = ref([])
let loading = ref(true)
let emailError = ref('')

const fetchRecipes = async () => {
  loading.value = true
  try {
    const { data, meta } = await $fetch(`${config.public.apiBase}/recipes`, {
      params: {
        keyword: search.keyword,
        email: search.email,
        ingredient: search.ingredient,
        page: pagination.currentPage,
      },
    })

    if (data) {
      recipes = data
      pagination.from = meta?.from
      pagination.to = meta?.to
      pagination.lastPage = meta?.last_page
      pagination.currentPage = meta?.current_page || 1
    }
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
}

const validateEmail = (email) => {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return re.test(email)
}

onMounted(() => {
    fetchRecipes()
})

watch(
  () => pagination.currentPage,
  (newPage, oldPage) => {
    fetchRecipes()
  }
)

const onSearch = () => {
  emailError.value = ''
  pagination.currentPage = 1

  if (search.email) { 
    if (!validateEmail(search.email)) {
      emailError.value = 'Invalid email address'
      return
    }
  }
  fetchRecipes()
}

const changePage = (newPage) => {
    pagination.currentPage = newPage
}
</script>

<template>
    <section class="space-y-8">
        <!-- Search Inputs -->
        <div class="grid grid-cols-4 mb-4 max-w-4xl">
            <div>
                <input
                    type="text"
                    v-model="search.keyword"
                    placeholder="Keyword"
                    class="border px-3 py-1 rounded"
                />
            </div>
            
            <div>
                <input
                    type="text"
                    v-model="search.email"
                    placeholder="Author Email"
                    :class="['border rounded px-3 py-1', emailError ? 'border-red-500' : 'border-gray-300']"
                />
                <span v-if="emailError" class="text-red-500 text-sm">{{ emailError }}</span>
            </div>
            
            <div>
                <input
                    type="text"
                    v-model="search.ingredient"
                    placeholder="Ingredient"
                    class="border px-3 py-1 rounded"
                />
            </div>

            <div>
                <button
                    @click="onSearch"
                    class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700"
                >
                    Search
                </button>
            </div>
            
            
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="text-center text-gray-500">
            Loading...
        </div>

        <!-- Table -->
        <div v-else class="space-y-8 overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="border border-gray-200 px-4 py-3 text-left">Name</th>
                    <th class="border border-gray-200 px-4 py-3 text-left">Author</th>
                    <th class="border border-gray-200 px-4 py-3 text-left">Created At</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="recipe in recipes"
                    :key="recipe.id"
                    class="hover:bg-gray-100"
                >
                    <td class="border border-gray-200 px-4 py-3">
                        <NuxtLink
                            :to="`/recipes/${recipe.slug}`"
                            class="text-blue-600 hover:underline"
                        >
                            {{ recipe.name }}
                        </NuxtLink>
                    </td>
                    <td class="border border-gray-200 px-4 py-3">
                        {{ recipe.email }}
                    </td>
                    <td class="border border-gray-200 px-4 py-3">
                        {{ recipe.created_at }}
                    </td>
                </tr>
                <tr v-if="recipes.length === 0 && !loading">
                    <td colspan="2" class="px-4 py-6 text-center text-gray-500">
                        No recipes found.
                    </td>
                </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div v-if="pagination.lastPage > 1" class="flex justify-between">
                <p>Showing {{ pagination.from }} to {{  pagination.to }} records</p>
                <div
                    class="flex items-center justify-center space-x-3"
                >
                    <button
                        :disabled="pagination.currentPage <= 1 || loading"
                        @click="changePage(pagination.currentPage - 1)"
                        class="rounded bg-gray-200 px-3 py-1 disabled:opacity-50"
                    >
                        Previous
                    </button>
                    <span>Page {{ pagination.currentPage }} of {{ pagination.lastPage }}</span>
                    <button
                        :disabled="pagination.currentPage >= pagination.lastPage || loading"
                        @click="changePage(pagination.currentPage + 1)"
                        class="rounded bg-gray-200 px-3 py-1 disabled:opacity-50"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>

        
    </section>
</template>