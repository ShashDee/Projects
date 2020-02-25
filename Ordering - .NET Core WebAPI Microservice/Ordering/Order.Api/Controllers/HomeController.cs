using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Http.Extensions;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;

namespace Ordering.Api.Controllers
{
    public class HomeController : Controller
    {
        private readonly IWebHostEnvironment _environment;
        private readonly ILogger<HomeController> _logger;

        public HomeController(IWebHostEnvironment environment, ILogger<HomeController> logger)
        {
            _environment = environment ?? throw new ArgumentNullException(nameof(environment));
            _logger = logger ?? throw new ArgumentNullException(nameof(logger));
        }

        public IActionResult Index()
        {
            if (_environment.EnvironmentName == "Development")
            {
                return new RedirectResult("~/swagger");
            }

            _logger.LogInformation("Homepage is disabled in production. Returning 404.");
            _logger.LogInformation("Request from {RequestPath} with {Headers}", HttpContext.Request.GetDisplayUrl(), HttpContext.Request.Headers);
            return NotFound();
        }
    }
}
