<script setup lang="ts">
import Sidebar from '@/components/ui/sidebar/Sidebar.vue';
import { ResizablePanel } from '@/components/ui/resizable';
import Separator from '@/components/ui/separator/Separator.vue';
import { Icon } from '@iconify/vue';
import { useAuthStore } from '@/modules/auth/store/auth';
import UserSidebar from '@/modules/auth/components/sidebar/UserSidebar.vue';
import SidebarMenu from '@/modules/auth/components/sidebar/SidebarMenu.vue';
import DarkMode from '@/components/ui/darkmode-toggle/DarkMode.vue';
import NavigationBar from '@/components/ui/navbar/NavigationBar.vue';

const store = useAuthStore()
</script>

<template>
  <section class="h-dvh">
    <Sidebar>
      <template #content="{ isCollapsed }">
        <div class="flex h-full flex-col justify-between items">
          <div>
            <UserSidebar :user="store.user" :collapsed="isCollapsed"/>
            <Separator />
            <SidebarMenu :collapsed="isCollapsed" />
            <Separator />
          </div>
          <div class="px-3 mb-5">
            <button
              @click="store.logout"
              class="link px-4 w-full rounded-md text-sm flex justify-center"
              :class="{'items-center': isCollapsed}"
              :disabled="store.loading"
            >
              <Icon icon="mdi:location-exit" class="shrink-0"/>
              <span v-if="!isCollapsed">
                Log out
              </span>
            </button>
          </div>
        </div>
      </template>
      <template #view>
        <ResizablePanel class="!overflow-y-auto">
          <NavigationBar />
          <div class="p-7 overflow-y-auto">
            <RouterView />
          </div>
        </ResizablePanel>
      </template>
    </Sidebar>
  </section>
</template>