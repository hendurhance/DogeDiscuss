<template>
  <div class="notify-wrapper">
    <button class="notification" @click="openNotify">
      <svg
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M19.3399 14.49L18.3399 12.83C18.1299 12.46 17.9399 11.76 17.9399 11.35V8.82C17.9399 6.47 16.5599 4.44 14.5699 3.49C14.0499 2.57 13.0899 2 11.9899 2C10.8999 2 9.91994 2.59 9.39994 3.52C7.44994 4.49 6.09994 6.5 6.09994 8.82V11.35C6.09994 11.76 5.90994 12.46 5.69994 12.82L4.68994 14.49C4.28994 15.16 4.19994 15.9 4.44994 16.58C4.68994 17.25 5.25994 17.77 5.99994 18.02C7.93994 18.68 9.97994 19 12.0199 19C14.0599 19 16.0999 18.68 18.0399 18.03C18.7399 17.8 19.2799 17.27 19.5399 16.58C19.7999 15.89 19.7299 15.13 19.3399 14.49Z"
          :fill="unreadCount > 0 ? '#FF3838' : '#FF3838b3'"
        />
        <path
          d="M14.8297 20.01C14.4097 21.17 13.2997 22 11.9997 22C11.2097 22 10.4297 21.68 9.87969 21.11C9.55969 20.81 9.31969 20.41 9.17969 20C9.30969 20.02 9.43969 20.03 9.57969 20.05C9.80969 20.08 10.0497 20.11 10.2897 20.13C10.8597 20.18 11.4397 20.21 12.0197 20.21C12.5897 20.21 13.1597 20.18 13.7197 20.13C13.9297 20.11 14.1397 20.1 14.3397 20.07C14.4997 20.05 14.6597 20.03 14.8297 20.01Z"
          :fill="unreadCount > 0 ? '#FF3838' : '#FF3838b3'"
        />
      </svg>
      <span class="notify__count">{{ unreadCount }}</span>
    </button>
    <div class="notify-content" v-if="notify">
      <div class="notify-items" v-if="unreadCount > 0">
        <div class="notify-item" v-for="unre in unread" :key="unre.id">
          <p @click="markAsRead(unre.id)">
            A new reply from {{ unre.data.reply_by }} on
            <router-link
              :to="{ name: 'question', params: { slug: unre.data.slug } }"
            >
              {{ unre.data.question }}
            </router-link>
          </p>
        </div>
      </div>
      <div class="notify-items" v-else>
        <div class="notify-item">
          <p>No unread notifications</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      notify: false,
      read: {},
      unread: {},
      unreadCount: 0,
      sound: "https://soundbible.com/mp3/glass_ping-Go445-1207030150.mp3",
    };
  },
  methods: {
    openNotify() {
      this.notify = !this.notify;
    },
    getNotification() {
      axios
        .get("/api/notifications")
        .then((response) => {
          this.read = response.data.read;
          this.unread = response.data.unread;
          this.unreadCount = Object.keys(this.unread).length;
        })
        .catch((error) => {
          Exception.handle(error);
        });
    },
    markAsRead(id) {
      axios
        .post(`/api/notifications/${id}`)
        .then((response) => {
          this.unreadCount--;
          // remove this notification from unread array
          this.unread = this.unread.filter((unread) => {
            return unread.id !== id;
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    playSound() {
      let alert = new Audio(this.sound);
      alert.play();
    },
  },
  mounted() {
    // if user is logged in
    if (User.checkIfLoggedIn()) {
      this.getNotification();
    }
  },
  created() {
    // Event listener for Notification for new reply
    Echo.private("App.Models.User." + User.getUsersId()).notification(
      (notification) => {
        if (notification.type == "App\\Notifications\\NewReplyNotification") {
          // create a new notification to unread array
          const newNotification = {
            id: notification.id,
            data: {
              reply_by: notification.reply_by,
              slug: notification.slug,
              question: notification.reply.question,
            },
          }
          // use audio to notify user
          this.playSound();
          this.unread.unshift(newNotification);
          this.unreadCount++;
        }
      }
    );
  },
  watch: {
    // if route change close notify
    $route() {
      this.notify = false;
    },
  }
};
</script>

<style>
notify-wrapper {
  position: relative;
}

button.notification {
  padding: 0 20px;
  border: none;
  background: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.notification span {
  font-size: 16px;
  font-weight: 700;
  color: #000;
}

.notify-content {
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  background: #fff;
  border-radius: 4px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  z-index: 9999;
}

.notify-items {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.notify-item {
  padding: 10px 0;
  border-bottom: 1px solid #eee;
}

.notify-item:last-child {
  border-bottom: none;
}

.notify-item p {
  font-size: 14px;
  font-weight: 500;
  color: rgb(27, 27, 27);
  opacity: 0.7;
  margin-bottom: 10px;
}

.notify-item p a {
  color: #000;
  opacity: 1;
}

@media (max-width: 480px) {
  button.notification {
    padding: 0 10px;
  }
}

@media (max-width: 359px) {
  .notification svg {
    width: 20px;
    height: 20px;
  }
  .notification span {
    font-size: 12px;
    font-weight: 400;
  }
}
</style>