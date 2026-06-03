allprojects {
    repositories {
        google()
        mavenCentral()
    }
}

val newBuildDir: Directory =
    rootProject.layout.buildDirectory
        .dir("../../build")
        .get()
rootProject.layout.buildDirectory.value(newBuildDir)

subprojects {
    val newSubprojectBuildDir: Directory = newBuildDir.dir(project.name)
    project.layout.buildDirectory.value(newSubprojectBuildDir)
}
subprojects {
    project.evaluationDependsOn(":app")
}

// Workaround untuk build error pada camera_android_camerax:
// class file for androidx.concurrent.futures.CallbackToFutureAdapter not found.
// CameraX membutuhkan androidx.concurrent pada compile classpath.
subprojects {
    configurations.configureEach {
        resolutionStrategy.force("androidx.concurrent:concurrent-futures:1.2.0")
    }

    if (project.name == "camera_android_camerax") {
        plugins.withId("com.android.library") {
            dependencies.add("implementation", "androidx.concurrent:concurrent-futures:1.2.0")
        }
    }
}

tasks.register<Delete>("clean") {
    delete(rootProject.layout.buildDirectory)
}
