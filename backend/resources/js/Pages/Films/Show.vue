<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({ film: Object })

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
</script>

<template>
  <AppLayout :title="film.titre">

    <div class="max-w-3xl mx-auto">

      <!-- Retour -->
      <Link href="/films" class="text-gray-400 hover:text-gray-600 text-sm mb-6 inline-block">
        ← Retour aux films
      </Link>

      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row">

          <!-- Affiche placeholder -->
          <div class="w-full md:w-56 bg-indigo-50 flex items-center justify-center text-8xl py-12 shrink-0">
            {{ GENRES[film.genre] ?? '🎬' }}
          </div>

          <!-- Infos -->
          <div class="p-6 flex-1">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ film.titre }}</h1>

            <!-- Badges -->
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="bg-indigo-100 text-indigo-700 text-xs font-medium px-3 py-1 rounded-full">
                {{ film.genre }}
              </span>
              <span class="bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">
                {{ film.annee }}
              </span>
              <span v-if="film.duree_minutes" class="bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">
                {{ film.duree_minutes }} min
              </span>
            </div>

            <!-- Réalisateur -->
            <p v-if="film.realisateur" class="text-sm text-gray-500 mb-4">
              Réalisé par <strong class="text-gray-700">{{ film.realisateur }}</strong>
            </p>

            <!-- Description -->
            <p class="text-gray-600 leading-relaxed">
              {{ film.description ?? 'Aucune description disponible.' }}
            </p>

          </div>
        </div>
      </div>

    </div>
  </AppLayout>
</template>
