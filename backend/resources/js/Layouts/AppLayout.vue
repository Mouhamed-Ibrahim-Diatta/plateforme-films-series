<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({ title: String })
</script>

<template>
  <div class="min-h-screen bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow mb-8">
      <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
        <Link href="/" class="text-xl font-bold text-indigo-600">
          🎬 FilmZone
        </Link>
        <div class="flex gap-6 text-sm font-medium text-gray-600">
          <Link href="/films" class="hover:text-indigo-600">Films</Link>
        </div>
      </div>
    </nav>

    <!-- Contenu -->
    <main class="max-w-5xl mx-auto px-4 pb-12">
      <slot />
    </main>

  </div>
</template>
