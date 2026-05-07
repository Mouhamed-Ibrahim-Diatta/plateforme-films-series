<script setup>
import { useForm, Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({ film: Object })

const user = usePage().props.auth?.user

const GENRES = {
  'Action': '🎬', 'Comédie': '😂', 'Drame': '🎭',
  'Horreur': '👻', 'Science-fiction': '🚀', 'Thriller': '🔪',
  'Animation': '🎨', 'Documentaire': '📽️',
}

// Formulaire d'avis
const form = useForm({
  film_id:     props.film.id,
  note:        5,
  commentaire: '',
})

const submitAvis = () => {
  form.post('/avis', {
    preserveScroll: true,
    onSuccess: () => form.reset('commentaire'),
  })
}
</script>

<template>
  <AppLayout :title="film.titre">
    <div class="max-w-3xl mx-auto">

      <!-- Retour -->
      <Link href="/films" class="text-gray-400 hover:text-gray-600 text-sm mb-6 inline-block">
        ← Retour aux films
      </Link>

      <!-- Détail film -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="flex flex-col md:flex-row">

          <!-- Emoji genre -->
          <div class="w-full md:w-56 bg-indigo-50 flex items-center justify-center text-8xl py-12 shrink-0">
            {{ GENRES[film.genre] ?? '🎬' }}
          </div>

          <!-- Infos -->
          <div class="p-6 flex-1">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ film.titre }}</h1>

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

            <p v-if="film.realisateur" class="text-sm text-gray-500 mb-4">
              Réalisé par <strong class="text-gray-700">{{ film.realisateur }}</strong>
            </p>

            <p class="text-gray-600 leading-relaxed mb-4">
              {{ film.description ?? 'Aucune description disponible.' }}
            </p>

            <!-- Note moyenne -->
            <div class="flex items-center gap-2">
              <span class="text-2xl font-bold text-yellow-500">★</span>
              <span class="text-xl font-bold text-gray-800">
                {{ film.note_moyenne ? film.note_moyenne.toFixed(1) : '—' }}
              </span>
              <span class="text-sm text-gray-400">
                / 10 · {{ film.avis?.length ?? 0 }} avis
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Formulaire avis (connecté seulement) -->
      <div v-if="user" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-4">⭐ Laisser un avis</h2>
        <form @submit.prevent="submitAvis" class="space-y-4">

          <!-- Slider note -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Note : <span class="text-indigo-600 font-bold text-lg">{{ form.note }}</span> / 10
            </label>
            <input
              v-model="form.note"
              type="range" min="1" max="10" step="1"
              class="w-full accent-indigo-600"
            />
            <div class="flex justify-between text-xs text-gray-400 mt-1">
              <span>1 - Nul</span>
              <span>5 - Moyen</span>
              <span>10 - Excellent</span>
            </div>
          </div>

          <!-- Commentaire -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Commentaire <span class="text-gray-400">(optionnel)</span>
            </label>
            <textarea
              v-model="form.commentaire"
              rows="3"
              placeholder="Donnez votre avis sur ce film..."
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"
            />
            <p v-if="form.errors.commentaire" class="text-red-500 text-xs mt-1">
              {{ form.errors.commentaire }}
            </p>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition disabled:opacity-50"
          >
            {{ form.processing ? 'Envoi...' : 'Publier mon avis' }}
          </button>

        </form>
      </div>

      <!-- Message si non connecté -->
      <div v-else class="bg-gray-50 rounded-xl border border-gray-200 p-6 mb-8 text-center">
        <p class="text-gray-500 text-sm">
          <Link href="/login" class="text-indigo-600 hover:underline font-medium">
            Connectez-vous
          </Link>
          pour laisser un avis.
        </p>
      </div>

      <!-- Liste des avis -->
      <div>
        <h2 class="text-lg font-bold text-gray-800 mb-4">
          💬 Avis ({{ film.avis?.length ?? 0 }})
        </h2>

        <div v-if="film.avis?.length" class="space-y-4">
          <div
            v-for="avis in film.avis"
            :key="avis.id"
            class="bg-white rounded-xl border border-gray-100 p-4"
          >
            <div class="flex items-center justify-between mb-2">
              <span class="font-medium text-gray-800">{{ avis.user.name }}</span>
              <div class="flex items-center gap-1">
                <span class="text-yellow-500">★</span>
                <span class="font-bold text-gray-700">{{ avis.note }}/10</span>
              </div>
            </div>
            <p class="text-gray-600 text-sm">
              {{ avis.commentaire ?? 'Aucun commentaire.' }}
            </p>

            <!-- Bouton supprimer (son propre avis) -->
            <div v-if="user && user.id === avis.user_id" class="mt-2">
              <Link
                :href="`/avis/${avis.id}`"
                method="delete"
                as="button"
                class="text-xs text-red-400 hover:text-red-600"
              >
                Supprimer mon avis
              </Link>
            </div>
          </div>
        </div>

        <div v-else class="text-center py-8 text-gray-400">
          <p>Aucun avis pour ce film. Soyez le premier !</p>
        </div>
      </div>

    </div>
  </AppLayout>
</template>
