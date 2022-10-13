variable "TAG" {
    default = "latest"
}

group "default" {
    targets = ["app"]
}

target "app" {
    target = "app"
    args = {
        BUILDKIT_INLINE_CACHE = 1
    }
    tags = [
        "pandawa/bima:${TAG}",
        "pandawa/bima:latest"
    ]
    platforms = [
        "linux/amd64",
        "linux/arm64"
    ]
}
