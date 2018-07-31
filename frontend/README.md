# Frontend

## Project setup
```
npm install
```

## Run
### Start fake server
Starts the fake backend server with full support of REST API json on http://localhost:3000. 

More info [here](https://github.com/typicode/json-server)
```
npm run fake
```

### Start the development environment
Usually runs in separate terminal. 
The command starts the dev environment on http://localhost:8080
```
npm run dev
```

## Other features
### Compiles and minifies for production
Creates a dist folder with static files.
```
npm run build
```
For opening the production frontend distro run command below.
The command can be reviewed in package.json.
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
Sometime the error `Error: ENOSPC` appears.
Something about fs.fileWatcher in Lunux based os.

### Temporary fix
Increase the number of watchers from defaults 8192
```
sudo sysctl fs.inotify.max_user_watches=524288
```

### Permanent fix (Not recommended)
If you are running Debian, RedHat, or another similar Linux distribution, run the following in a terminal:
```
echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf && sudo sysctl -p
```
If you are running ArchLinux, run the following command instead:
```
echo fs.inotify.max_user_watches=524288 | sudo tee /etc/sysctl.d/40-max-user-watches.conf && sudo sysctl --system
```
