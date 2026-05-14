<script setup>
import { Link } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

defineProps({ title: String })

const { props } = usePage()
const user = props.auth?.user
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
          <Link href="/series" class="hover:text-indigo-600">Séries</Link>

          <template v-if="user">
            <span class="text-gray-800 font-semibold">👤 {{ user.name }}</span>
            <Link href="/logout" method="post" as="button" class="hover:text-red-500">Déconnexion</Link>
          </template>
          <template v-else>
            <Link href="/login" class="hover:text-indigo-600">Connexion</Link>
            <Link href="/register" class="hover:text-indigo-600">Inscription</Link>
          </template>
        </div>
      </div>
    </nav>

    <!-- Contenu -->
    <main class="max-w-5xl mx-auto px-4 pb-12">
      <slot />
    </main>

  </div>
</template>