<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout title="Accueil">

    <div class="text-center py-20">
      <h1 class="text-4xl font-bold text-gray-800 mb-4">
        🎬 Bienvenue sur FilmZone
      </h1>
      <p class="text-gray-500 text-lg mb-8">
        Découvrez et gérez votre catalogue de films et séries
      </p>
      <Link
        href="/films"
        class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 transition"
      >
        Voir les films
      </Link>
    </div>

  </AppLayout>
</template>
