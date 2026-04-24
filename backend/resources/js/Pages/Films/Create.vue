<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const form = useForm({
  titre:          '',
  description:    '',
  genre:          '',
  annee:          new Date().getFullYear(),
  realisateur:    '',
  duree_minutes:  '',
})

const GENRES = ['Action', 'Comédie', 'Drame', 'Horreur', 'Science-fiction', 'Thriller', 'Animation', 'Documentaire']

const submit = () => {
  form.post('/films')
}
</script>

<template>
  <AppLayout title="Ajouter un film">

    <div class="max-w-2xl mx-auto">

      <!-- En-tête -->
      <div class="flex items-center gap-4 mb-6">
        <Link href="/films" class="text-gray-400 hover:text-gray-600">← Retour</Link>
        <h1 class="text-2xl font-bold text-gray-800">Ajouter un film</h1>
      </div>

      <!-- Formulaire -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form @submit.prevent="submit" class="space-y-5">

          <!-- Titre -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
            <input
              v-model="form.titre"
              type="text"
              placeholder="Ex: Inception"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
            />
            <p v-if="form.errors.titre" class="text-red-500 text-xs mt-1">{{ form.errors.titre }}</p>
          </div>

          <!-- Genre -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Genre *</label>
            <select
              v-model="form.genre"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
            >
              <option value="">Choisir un genre</option>
              <option v-for="g in GENRES" :key="g" :value="g">{{ g }}</option>
            </select>
            <p v-if="form.errors.genre" class="text-red-500 text-xs mt-1">{{ form.errors.genre }}</p>
          </div>

          <!-- Année + Durée -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Année *</label>
              <input
                v-model="form.annee"
                type="number"
                min="1888" max="2099"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
              />
              <p v-if="form.errors.annee" class="text-red-500 text-xs mt-1">{{ form.errors.annee }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Durée (minutes)</label>
              <input
                v-model="form.duree_minutes"
                type="number"
                min="1"
                placeholder="Ex: 148"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
              />
            </div>
          </div>

          <!-- Réalisateur -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Réalisateur</label>
            <input
              v-model="form.realisateur"
              type="text"
              placeholder="Ex: Christopher Nolan"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
            />
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
              v-model="form.description"
              rows="4"
              placeholder="Résumé du film..."
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"
            />
          </div>

          <!-- Boutons -->
          <div class="flex gap-3 pt-2">
            <button
              type="submit"
              :disabled="form.processing"
              class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition disabled:opacity-50"
            >
              {{ form.processing ? 'Enregistrement...' : 'Ajouter le film' }}
            </button>
            <Link
              href="/films"
              class="px-6 py-2 rounded-lg text-sm font-medium border border-gray-300 text-gray-600 hover:bg-gray-50 transition"
            >
              Annuler
            </Link>
          </div>

        </form>
      </div>

    </div>
  </AppLayout>
</template>
