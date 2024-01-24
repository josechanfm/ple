<template>
  <a-row>
    <a-col flex="auto">
        <p>Title: {{ course.title }}</p>
        <p>Learn: {{ course.learn }}</p>
        <p>Brief: {{ course.brief }}</p>
        <p>Description: {{ course.description }}</p>
        <p>Start On: {{ course.start_on }}</p>
        <p>Finish On: {{ course.finish_on }}</p>
        <span v-if="!course.published">
          <p>This course is not yet published!</p>
        </span>
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