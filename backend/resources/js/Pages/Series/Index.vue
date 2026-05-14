<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  series: Array,
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
  router.get('/series', {
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
  <AppLayout title="Séries">

    <!-- En-tête -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Catalogue Séries</h1>
      <Link
        href="/series/create"
        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition"
      >
        + Ajouter une série
      </Link>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="flex flex-col md:flex-row gap-3 mb-6">

      <!-- Recherche -->
      <input
        v-model="search"
        type="text"
        placeholder="Rechercher une série..."
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
        min="1900"
        max="2099"
        class="w-40 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
      />

    </div>

    <!-- Grille de séries -->
    <div v-if="series.length" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
      <Link
        v-for="serie in series"
        :key="serie.id"
        :href="`/series/${serie.id}`"
        class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden group relative"
      >
        <span v-if="serie.statut === 'en_cours'" class="absolute top-2 right-2 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded-full z-10">En cours</span>
        <span v-else-if="serie.statut === 'terminee'" class="absolute top-2 right-2 bg-gray-500 text-white text-[10px] font-bold px-2 py-1 rounded-full z-10">Terminée</span>
        <span v-else class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full z-10">Annulée</span>

        <!-- Placeholder affiche -->
        <div class="aspect-[2/3] bg-indigo-50 flex items-center justify-center text-5xl">
          <img v-if="serie.affiche"
              :src="`/storage/${serie.affiche}`"
              :alt="serie.titre"
              class="w-full h-full object-cover" />
          <span v-else>{{ GENRES[serie.genre] ?? '📺' }}</span>
        </div>
        <!-- Infos -->
        <div class="p-3">
          <h3 class="font-semibold text-gray-800 truncate group-hover:text-indigo-600">
            {{ serie.titre }}
          </h3>
          <div class="flex items-center justify-between mt-1">
            <span class="text-xs text-gray-400">{{ serie.annee_debut }} - {{ serie.annee_fin ?? '?' }}</span>
            <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">
              {{ serie.nb_saisons }} S
            </span>
          </div>
        </div>
      </Link>
    </div>

    <!-- Aucune série -->
    <div v-else class="text-center py-20 text-gray-400">
      <p class="text-5xl mb-4">📺</p>
      <p class="text-lg">Aucune série trouvée.</p>
      <Link href="/series/create" class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
        Ajouter la première série →
      </Link>
    </div>

  </AppLayout>
</template>
