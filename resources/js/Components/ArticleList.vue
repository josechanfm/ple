<script setup>

const props = defineProps({
    articles: Object
});
</script>

<template>
                  <a-list item-layout="horizontal" :data-source="articles">
        <template #renderItem="{ item }">
          <a-list-item>
            <a-list-item-meta >
              <template #title>
                <inertia-link :href="route('article.item', { t: item.uuid })">
                  {{ item.title_en }}
                </inertia-link>
              </template>
              <template #description>
                <div v-if="item.intro_en">
                  {{ item.intro_en }}
                </div>
                <div v-else>
                  {{ item.content_en.replace(/<[^>]+>/g, '').substring(0,100) }}
                </div>
              </template>
              <template #avatar>
                <a-avatar style="color: #f56a00; background-color: #fde3cf">
                  <template v-if="item.author" #icon>
                    {{ item.author.charAt(0).toUpperCase() }}
                  </template>
                  <template v-else #icon>
                    <UserOutlined />
                  </template>
                </a-avatar>
              </template>
            </a-list-item-meta>
          </a-list-item>
        </template>
      </a-list>

</template>
