<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  films: Array,
  filters: Object,
})

const GENRES = {
  'Action': '🎬',
  'Comédie': '😂',
  'Drame': '🎭',
  'Horreur': '👻',
  'Science-fiction': '🚀',
  'Thriller': '🔪',
  'Animation': '🎨',
  'Documentaire': '📽️',
}

// Récupère les filtres déjà actifs
const search = ref(props.filters?.search ?? '')
const genre  = ref(props.filters?.genre  ?? '')
const annee  = ref(props.filters?.annee  ?? '')

// Dès qu'un filtre change, on envoie la requête à Laravel
watch([search, genre, annee], () => {
  router.get('/films', {
    search: search.value,
    genre:  genre.value,
    annee:  annee.value,
  }, {
    preserveState: true,
    replace: true,
  })
})
</script>

<template>
  <AppLayout title="Films">

    <!-- En-tête -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Catalogue Films</h1>
      <Link
        href="/films/create"
        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition"
      >
        + Ajouter un film
      </Link>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="flex flex-col md:flex-row gap-3 mb-6">

      <!-- Recherche -->
      <input
        v-model="search"
        type="text"
        placeholder="Rechercher un film..."
        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
      />

      <!-- Filtre genre -->
      <select
        v-model="genre"
        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
      >
        <option value="">Tous les genres</option>
        <option v-for="(emoji, g) in GENRES" :key="g" :value="g">
          {{ emoji }} {{ g }}
        </option>
      </select>

      <!-- Filtre année -->
      <input
        v-model="annee"
        type="number"
        placeholder="Année (ex: 2023)"
        min="1888"
        max="2099"
        class="w-40 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
      />

    </div>

    <!-- Grille de films -->
    <div v-if="films.length" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
      <Link
        v-for="film in films"
        :key="film.id"
        :href="`/films/${film.id}`"
        class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden group"
      >
        <!-- Placeholder affiche -->
        <div class="aspect-[2/3] bg-indigo-50 flex items-center justify-center text-5xl">
          {{ GENRES[film.genre] ?? '🎬' }}
        </div>
        <!-- Infos -->
        <div class="p-3">
          <h3 class="font-semibold text-gray-800 truncate group-hover:text-indigo-600">
            {{ film.titre }}
          </h3>
          <div class="flex items-center justify-between mt-1">
            <span class="text-xs text-gray-400">{{ film.annee }}</span>
            <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">
              {{ film.genre }}
            </span>
          </div>
        </div>
      </Link>
    </div>

    <!-- Aucun film -->
    <div v-else class="text-center py-20 text-gray-400">
      <p class="text-5xl mb-4">🎬</p>
      <p class="text-lg">Aucun film trouvé.</p>
      <Link href="/films/create" class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
        Ajouter le premier film →
      </Link>
    </div>

  </AppLayout>
</template>