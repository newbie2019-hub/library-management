<script setup lang="ts">
import { ref } from 'vue';
import {
  ResizableHandle,
  ResizablePanel,
  ResizablePanelGroup,
} from '@/components/ui/resizable'

withDefaults(defineProps<{
  minSize?: number
  maxSize?: number
}>(), {
  minSize: 6,
  maxSize: 15
})

const isCollapsed = ref<boolean>(false)

const onCollapse = () => {
  isCollapsed.value = true
}

const onExpand = () => {
  isCollapsed.value = false
}
</script>

<template>
  <ResizablePanelGroup
    direction="horizontal"
    class="h-full"
  >
    <ResizablePanel
      :min-size="minSize"
      :max-size="maxSize"
      :collapsed-size="6"
      collapsible
      @collapse="onCollapse"
      @expand="onExpand"
      class="transition-all duration-300 ease-in-out"
    >
      <slot name="content" :is-collapsed="isCollapsed"/>
    </ResizablePanel>
    <ResizableHandle with-handle />
    <slot name="view"/>
  </ResizablePanelGroup>
</template>
