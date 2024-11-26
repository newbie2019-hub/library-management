<script setup lang="ts">
import { inject } from 'vue';
import Sidebar from '@/components/ui/sidebar/Sidebar.vue';
import { ResizablePanel } from '@/components/ui/resizable';
import Separator from '@/components/ui/separator/Separator.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import SidebarItem from '@/components/ui/sidebar/SidebarItem.vue';
import { routes } from '@/constants/routes';
import { userKey } from '@/@types/injection-key';
import { Icon } from '@iconify/vue';
import { useAuthStore } from '@/modules/auth/store/auth';

const user = inject(userKey)
const { logout } = useAuthStore()
</script>

<template>
  <section class="h-dvh">
    <Sidebar>
      <template #content="{ isCollapsed }">
        <div
          class="flex gap-x-2.5 items-center justify-center py-5"
          :class="{'px-4': !isCollapsed}"
        >
          <Avatar>
            <AvatarImage
              :src="`https://robohash.org/${user?.first_name}`"
              :alt="`${user?.first_name}`"
            />
            <AvatarFallback>
              {{ user?.first_name[0] }} {{ user?.last_name[0] }}
            </AvatarFallback>
          </Avatar>
          <div v-if="!isCollapsed" class="w-40">
            <p>{{ user?.first_name }} {{ user?.last_name }}</p>
            <p class="text-gray-600 text-xs truncate text-ellipsis">
              {{ user.email }}
            </p>
          </div>
        </div>
        <Separator />
        <div id="sidebar-options" class="pb-8 pt-4 px-3">
          <p
            class="text-sm mb-3 text-gray-700"
            :class="{'text-center': isCollapsed}"
          >
            Menu
          </p>
          <div class="flex flex-col gap-0.5">
            <SidebarItem
              v-for="route in routes"
              :key="route.label"
              :path="route.path"
              :icon="route.icon"
              :label="route.label"
              :collapsed="isCollapsed"
              rounded
            />
          </div>
        </div>
        <Separator />
        <div class="px-3">
          <button @click="logout" class="link w-full rounded-md px-4 text-sm">
            <Icon icon="mdi:location-exit" />
            Log out
          </button>
        </div>
      </template>
      <template #view>
        <ResizablePanel>
          <div class="p-4">
            <RouterView />
          </div>
        </ResizablePanel>
      </template>
    </Sidebar>
  </section>
</template>