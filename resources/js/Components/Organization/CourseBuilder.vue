<template>
  <a-row>
    <a-col flex="auto">
        <p>{{ course.title }}</p>
        <slot/>
    </a-col>
    <a-col flex="300px" class="bg-white">
      <ol>
        <li>
          <inertia-link :href="route('manage.files.index')">Files</inertia-link>
        </li>
        <li>
          <inertia-link :href="route('manage.pages.index')">Pages</inertia-link>
        </li>
        <li>Assignment</li>
        <li>Quiz</li>
        <li>Discussion</li>
      </ol>
    </a-col>
  </a-row>
    
</template>

  <script>
  import { defineComponent } from 'vue';

  export default defineComponent({
    components: {
    },
    props: ['course'],
    setup() {
      return {
      };
    },
  });
  </script>