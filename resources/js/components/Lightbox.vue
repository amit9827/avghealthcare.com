<template>
    <div>
      <!-- Trigger image -->
      <img
        :src="src"
        class="product_img cursor-zoom-in"

        :alt="alt"
        @click="open"
      />

      <!-- Lightbox Overlay -->
      <transition name="fade">
        <div v-if="visible" class="overlay" @click.self="close" ref="overlay">
          <button class="btn-close" @click="close">✕</button>

          <div
            class="viewer"
            ref="viewer"
            @wheel.prevent="onWheel"
            @mousedown="onDown"
            @mousemove="onMove"
            @mouseup="onUp"
            @mouseleave="onUp"
            @dblclick.prevent="toggleZoom"
          >
            <img
              :src="src"
              :alt="alt"
              class="lightbox-img"
              :style="imageStyle"
              draggable="false"
            />
          </div>
        </div>
      </transition>
    </div>
  </template>

  <script setup>
  import { ref, reactive, computed } from 'vue';

  const props = defineProps({
    src: { type: String, required: true },
    alt: { type: String, default: '' },
    imgClass: { type: String, default: 'product_img' },
    maxZoom: { type: Number, default: 3 }
  });

  const visible = ref(false);
  const overlay = ref(null);

  const transform = reactive({ scale: 1, x: 0, y: 0 });
  const drag = reactive({ active: false, startX: 0, startY: 0, origX: 0, origY: 0 });

  const imageStyle = computed(() => ({
    transform: `translate(${transform.x}px, ${transform.y}px) scale(${transform.scale})`,
    transition: drag.active ? 'none' : 'transform 200ms ease'
  }));

  function open() {
    visible.value = true;
    reset();
  }
  function close() {
    visible.value = false;
    reset();
  }
  function reset() {
    transform.scale = 1;
    transform.x = 0;
    transform.y = 0;
  }
  function onWheel(e) {
    const factor = e.deltaY < 0 ? 1.1 : 0.9;
    transform.scale = Math.min(props.maxZoom, Math.max(1, transform.scale * factor));
  }
  function toggleZoom() {
    transform.scale = transform.scale > 1 ? 1 : props.maxZoom;
    transform.x = 0;
    transform.y = 0;
  }

  // mouse drag
  function onDown(e) {
    if (transform.scale <= 1) return;
    drag.active = true;
    drag.startX = e.clientX;
    drag.startY = e.clientY;
    drag.origX = transform.x;
    drag.origY = transform.y;
  }
  function onMove(e) {
    if (!drag.active) return;
    transform.x = drag.origX + (e.clientX - drag.startX);
    transform.y = drag.origY + (e.clientY - drag.startY);
  }
  function onUp() {
    drag.active = false;
  }
  </script>

  <style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.2s;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }

  .overlay {
    position: fixed;
    inset: 0;
    background: rgba(10, 10, 10, 0.9);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .viewer {
    max-width: 90vw;
    max-height: 90vh;
    overflow: scroll;
    cursor: grab;
  }
  .viewer:active {
    cursor: grabbing;
  }

  .lightbox-img {
    max-width: 100%;
    max-height: 100%;
    user-select: none;
    pointer-events: none;
    transform-origin: center center;
  }

  .btn-close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 22px;
    color: #fff;
    background: transparent;
    border: none;
    cursor: pointer;
  }

  .product_img{
    max-width:100%;
    height:auto;
    width:auto;

    border-radius:10px;
    display: block;
  }

  .cursor-zoom-in {
  cursor: zoom-in;
}

.cursor-zoom-out {
  cursor: zoom-out;
}

  </style>
