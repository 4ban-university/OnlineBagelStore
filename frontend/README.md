# Frontend

## Project setup
```
npm install
```

### Start fake server
Starts the fake http server and returns fully supported REST API json
```
npm run fake
```

### Start the development environment
```
npm run dev
```

### Compiles and minifies for production
```
npm run build
```
For opening the production frontend distro:
```
npm run production
```
### Lints and fixes files
```
npm run lint
```
### Run your unit tests
```
npm run test:unit
```
## Troubleshooting
Sometime happens error: Error: ENOSPC.

### Temporary fix
Increase the number of watchers from defaults 8192
```
sudo sysctl fs.inotify.max_user_watches=524288
```

### Permanent fix
If you are running Debian, RedHat, or another similar Linux distribution, run the following in a terminal:
```
echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf && sudo sysctl -p
```
If you are running ArchLinux, run the following command instead:
```
echo fs.inotify.max_user_watches=524288 | sudo tee /etc/sysctl.d/40-max-user-watches.conf && sudo sysctl --system
```