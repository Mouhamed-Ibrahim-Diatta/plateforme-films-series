<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const form = useForm({
  titre:          '',
  description:    '',
  genre:          '',
  annee_debut:    new Date().getFullYear(),
  annee_fin:      null,
  nb_saisons:     1,
  statut:         'en_cours',
  affiche:        null,
})

const GENRES = ['Action', 'Comédie', 'Drame', 'Horreur', 'Science-fiction', 'Thriller', 'Animation', 'Documentaire']

const submit = () => {
  form.post('/series', { forceFormData: true })
}
</script>

<template>
  <AppLayout title="Ajouter une série">

    <div class="max-w-2xl mx-auto">

      <!-- En-tête -->
      <div class="flex items-center gap-4 mb-6">
        <Link href="/series" class="text-gray-400 hover:text-gray-600">← Retour</Link>
        <h1 class="text-2xl font-bold text-gray-800">Ajouter une série</h1>
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
              placeholder="Ex: Breaking Bad"
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

          <!-- Années -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Année de début *</label>
              <input
                v-model="form.annee_debut"
                type="number"
                min="1900" max="2099"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
              />
              <p v-if="form.errors.annee_debut" class="text-red-500 text-xs mt-1">{{ form.errors.annee_debut }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Année de fin</label>
              <input
                v-model="form.annee_fin"
                type="number"
                min="1900" max="2099"
                placeholder="Ex: 2013"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
              />
              <p v-if="form.errors.annee_fin" class="text-red-500 text-xs mt-1">{{ form.errors.annee_fin }}</p>
            </div>
          </div>

          <!-- Saisons et Statut -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de saisons *</label>
              <input
                v-model="form.nb_saisons"
                type="number"
                min="1"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
              />
              <p v-if="form.errors.nb_saisons" class="text-red-500 text-xs mt-1">{{ form.errors.nb_saisons }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
              <select
                v-model="form.statut"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
              >
                <option value="en_cours">En cours</option>
                <option value="terminee">Terminée</option>
                <option value="annulee">Annulée</option>
              </select>
              <p v-if="form.errors.statut" class="text-red-500 text-xs mt-1">{{ form.errors.statut }}</p>
            </div>
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
              v-model="form.description"
              rows="4"
              placeholder="Résumé de la série..."
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"
            />
          </div>

          <!-- Affiche -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Affiche (image)</label>
            <input
              type="file"
              accept="image/*"
              @change="form.affiche = $event.target.files[0]"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
            />
            <p v-if="form.errors.affiche" class="text-red-500 text-xs mt-1">{{ form.errors.affiche }}</p>
          </div>

          <!-- Boutons -->
          <div class="flex gap-3 pt-2">
            <button
              type="submit"
              :disabled="form.processing"
              class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition disabled:opacity-50"
            >
              {{ form.processing ? 'Enregistrement...' : 'Ajouter la série' }}
            </button>
            <Link
              href="/series"
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
