import { Link, Head } from "@inertiajs/react";
import { ExclamationCircleIcon } from "@heroicons/react/20/solid";
import PrimaryButton from "@/Components/PrimaryButton";

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    const handleImageError = () => {
        document
            .getElementById("screenshot-container")
            ?.classList.add("!hidden");
        document.getElementById("docs-card")?.classList.add("!row-span-1");
        document
            .getElementById("docs-card-content")
            ?.classList.add("!flex-row");
        document.getElementById("background")?.classList.add("!hidden");
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const email = document.getElementById("email").value;
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        if (email) {
            fetch("/subscribe", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ email }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert(data.message);
                    }
                });
        }
    };

    return (
        <>
            <Head title="Welcome" />
            <div className="bg-white text-black/50 dark:bg-black dark:text-white/50">
                <div className="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        {/* <header className="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                            <nav className="-mx-3 flex flex-1 justify-end">
                                {auth.user ? (
                                    <Link
                                        href={route("dashboard")}
                                        className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route("login")}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Log in
                                        </Link>
                                        <Link
                                            href={route("register")}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </Link>
                                    </>
                                )}
                            </nav>
                        </header> */}

                        <main className="mt-6">
                            <div class="relative w-full px-6 lg:max-w-7xl mx-auto items-center justify-center">
                                <div class="items-center justify-center mx-auto h-full mt-10">
                                    <img
                                        src="/photos/inday-logo-bw.svg"
                                        alt="Inday Genius Logo"
                                        class="h-14 sm:h-24 mx-auto"
                                    />
                                    <img
                                        src="/photos/inday-world.svg"
                                        alt="Inday Genius World"
                                        class="flex-1 md:w-[600px] mx-auto bg-white"
                                    />
                                </div>

                                <footer class="py-10 text-center text-sm text-black">
                                    <div
                                        class="max-w-xl lg:max-w-2xl items-center justify-center mx-auto font-comic
                                         rounded-xl border p-10 shadow-xl"
                                    >
                                        <h2 class="text-2xl font-bold tracking-tight text-black sm:text-4xl">
                                            Stay Updated with Our Latest News!
                                        </h2>
                                        <p class="mt-4 text-md sm:text-xl leading-8 text-gray-700">
                                            Join our mailing list to receive
                                            updates, and news regarding the
                                            exciting development happening in
                                            the world of Inday Genius.
                                        </p>
                                        <form
                                            action="/subscribe"
                                            method="POST"
                                            class="mt-6 flex max-w-md gap-x-4 mx-auto"
                                        >
                                            <label
                                                for="email-address"
                                                class="sr-only"
                                            >
                                                Email address
                                            </label>
                                            <div className="mt-2 rounded-md shadow-sm flex flex-1 items-center justify-between space-x-8">
                                                <input
                                                    type="email"
                                                    name="email"
                                                    id="email"
                                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                    placeholder="you@example.com"
                                                    aria-describedby="email-description"
                                                />
                                                {/* <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                    <ExclamationCircleIcon
                                                        className="h-5 w-5 text-red-500"
                                                        aria-hidden="true"
                                                    />
                                                </div> */}
                                                <PrimaryButton
                                                    type="submit"
                                                    className="h-10"
                                                    onClick={(e) => {
                                                        handleSubmit(e);
                                                    }}
                                                >
                                                    Subscribe
                                                </PrimaryButton>
                                            </div>

                                            {/* {error && (
                                                <p
                                                    className="mt-2 text-sm text-red-600"
                                                    id="email-error"
                                                >
                                                    Not a valid email address.
                                                </p>
                                            )} */}
                                        </form>
                                    </div>
                                </footer>
                            </div>
                        </main>

                        {/* <footer className="py-16 text-center text-sm text-black dark:text-white/70">
                            Laravel v{laravelVersion} (PHP v{phpVersion})
                        </footer> */}
                    </div>
                </div>
            </div>
        </>
    );
}
