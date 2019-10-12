- create .env file in Magento root folder and put a comma separated list of allowed folders under key MAGESYMLINK_ALLOWED_PATHS, like this:
    + MAGESYMLINK_ALLOWED_PATHS=/somefolder/subfolder,/someotherfolder
    
These folders will pass Magento path validator in read/write filesystem factories

Why would you want this? Well, you might have partial deploys which are symlinked, for example:
app/code, app/design, pub/static and vendor could be symlinked to a folder outside of Magento, named by a commit hash.
