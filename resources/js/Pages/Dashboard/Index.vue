<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
    <div class="grid lg:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 gap-4 mt-3">
      <div v-if="can('view-events-count')" class="flex flex-col p-3 rounded-lg h-full w-full bg-white h-1/2 shadow-lg p-4">
        <div class="flex flex-wrap items-center">
          <icon name="megaphone" class="mr-2 w-10 h-10 fill-indigo-600" />
          <h4 class="mt-2 text-xl font-semibold">Total Events : {{ eventsCount }}</h4>
        </div>
      </div>
      <div v-if="can('view-users-count')" class="p-3 rounded-lg bg-white h-full shadow-lg w-full p-4">
        <div class="flex flex-wrap items-center">
          <icon name="users" class="mr-2 w-10 h-10 fill-indigo-600" />
          <h4 class="mt-2 text-xl font-semibold">Total Users : {{ usersCount }}</h4>
        </div>
      </div>
      <div v-if="can('view-my-events-count')" class="flex flex-col p-3 rounded-lg h-full w-full bg-white h-1/2 shadow-lg p-4">
        <div class="flex flex-wrap items-center">
          <icon name="megaphone" class="mr-2 w-10 h-10 fill-indigo-600" />
          <h4 class="mt-2 text-xl font-semibold">My Events : {{ userEventsCount }}</h4>
        </div>
      </div>
      <div v-if="can('view-articles-count')" class="p-3 rounded-lg bg-white h-full shadow-lg w-full p-4">
        <div class="flex flex-wrap items-center">
          <icon name="news" class="mr-2 w-10 h-10 fill-indigo-600" />
          <h4 class="mt-2 text-xl font-semibold">Total Articles : {{ articlesCount }}</h4>
        </div>
      </div>
    </div>
    <div v-if="can('full-access')" class="bg-white rounded shadow overflow-x-auto p-8 my-5">
      <h1 class="mb-4 font-bold text-xl">The Teams</h1>
      <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
        <div v-for="data in dataKelompok" :key="data.nim" class="bg-white shadow-lg hover:shadow-2xl shadow-md transition-all duration-350 ease-in-out antialiased text-gray-900 rounded-lg">
          <div class="p-5">
            <img :src="data.image ? data.image : 'https://dummyimage.com/16:16x1080/'" alt=" random imgee" class="w-full h-72 object-cover object-center rounded-lg shadow-md">
            <div class="relative px-4 -mt-16  ">
              <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-baseline">
                  <span class="bg-teal-200 text-teal-800 text-xs inline-block rounded-full uppercase font-semibold tracking-wide">
                    {{ data.nim }} /
                    <span class="px-2 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                      SI-3B
                    </span>
                  </span>
                </div>

                <h4 class="mt-1 text-md font-semibold leading-tight truncate" :title="data.name">{{ data.name }}</h4>

                <div class="mt-4">
                  <span class="text-teal-600 text-md font-semibold">
                    <a :href="data.instagram" target="_blank" class="mr-2">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="hover:cursor-pointer hover:text-indigo-500 inline-block bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                      </svg>
                    </a>
                    <a :href="data.linkedin" target="_blank" class="mr-2">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="hover:cursor-pointer hover:text-indigo-500 inline-block bi bi-linkedin" viewBox="0 0 16 16">
                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                      </svg>
                    </a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import Icon from '@/Shared/Icon'

export default {
  metaInfo: { title: 'Dashboard' },

  components: {
    Icon,
  },

  layout: Layout,

  props: {
    usersCount: [Number],
    eventsCount: [Number],
    articlesCount: [Number],
    userEventsCount: [Number],
  },

  data: () => ({
    dataKelompok: [
      {
        name: 'Rully Afrizal Alwin',
        nim: '203140914111049',
        image: 'https://drive.google.com/uc?export=view&id=1J2v53WIkgrjtsO8RjnZv7vjc8GQp7zCs',
        instagram: 'https://www.instagram.com/rullyafrizal/',
        linkedin: 'https://www.linkedin.com/in/rully-afrizal-alwin-ba1572211/',
      },
      {
        name: 'Irfan Rizky Anugrah',
        nim: '203140914111066',
        image: 'https://drive.google.com/uc?export=view&id=1Ti8BfWpFcLhEwQzDJN7gYzJhcSp5PNdL',
        instagram: 'https://www.instagram.com/irfanrzkyy/',
        linkedin: '',
      },
      {
        name: 'Dinda Wahyu Febrianti',
        nim: '203140914111040',
        image: 'https://drive.google.com/uc?export=view&id=1s_hgipuzAPWYOxMENEwEKTw2aGB7dvWS',
        instagram: 'https://www.instagram.com/dinda_wahyufebianti/',
        linkedin: '',
      },
      {
        name: 'Bernardus Angelo Johan Fernandy',
        nim: '203140914111043',
        image: 'https://drive.google.com/uc?export=view&id=1SQIcZO4FdScjuxCUJLkt980Bzo3TBZg-',
        instagram: 'https://www.instagram.com/lilofernandi14/',
        linkedin: 'https://www.linkedin.com/in/bernardus-angelo-johan-fernandtly-5415321b8',
      },
      {
        name: 'Roziqul Abidin',
        nim: '203140914111063',
        image: 'https://drive.google.com/uc?export=view&id=1DeFcjqCATsKDAkWw8ibNhu4_jTXYykBr',
        instagram: 'https://www.instagram.com/_abiiddd_/',
        linkedin: '',
      },
      {
        name: 'Irma Nur Ardiyanti',
        nim: '203140914111046',
        image: 'https://drive.google.com/uc?export=view&id=1l22qmOyHxgsrDjqUv3Jqr4tRphz50yO8',
        instagram: 'https://www.instagram.com/irmatsqb/',
        linkedin: '',
      },
    ],
  }),
}
</script>
