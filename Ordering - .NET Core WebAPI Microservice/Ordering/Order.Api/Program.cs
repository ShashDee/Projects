using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Reflection;
using System.Threading.Tasks;
using Autofac.Extensions.DependencyInjection;
using Microsoft.AspNetCore.Hosting;
using Microsoft.EntityFrameworkCore;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Hosting;
using Microsoft.Extensions.Logging;
using Ordering.Infrastructure;
using Serilog;

namespace Ordering.Api
{
    public class Program
    {
        public static readonly string Namespace = typeof(Program).Namespace;
        public static readonly string AppName = Namespace.Substring(Namespace.LastIndexOf('.', Namespace.LastIndexOf('.') - 1) + 1);

        public static void Main(string[] args)
        {
            Log.Logger = CreateSerilogLogger(GetBasicConfiguration());

            Log.Information("Configuring web host ({ApplicationContext})...", AppName);

            var options = GetDBOptions();

            using (var context = new OrderContext(options))
            {
                // Migrate the database
                context.Database.Migrate();
            }

            Log.Information("Starting web host ({ApplicationContext})...", AppName);
            CreateHostBuilder(args).Build().Run();
        }

        public static IHostBuilder CreateHostBuilder(string[] args) =>
            Host.CreateDefaultBuilder(args)
            .UseServiceProviderFactory(new AutofacServiceProviderFactory())
            .ConfigureWebHostDefaults(webHostBuilder => {
            webHostBuilder
              .UseContentRoot(Directory.GetCurrentDirectory())
              .UseIISIntegration()
              .UseStartup<Startup>();
        });

        private static Serilog.ILogger CreateSerilogLogger(IConfiguration configuration)
        {
            var seqServerUrl = configuration["Serilog:SeqServerUrl"];

            return new LoggerConfiguration()
                .MinimumLevel.Verbose()
                .Enrich.WithProperty("ApplicationContext", AppName)
                .Enrich.FromLogContext()
                .WriteTo.Console()
                .WriteTo.Seq(string.IsNullOrWhiteSpace(seqServerUrl) ? "http://seq" : seqServerUrl)
                .ReadFrom.Configuration(configuration)
                .CreateLogger();
        }

        private static IConfiguration GetBasicConfiguration()
        {
            // Support for Migrations builder.
            var builder = new ConfigurationBuilder()
                .SetBasePath(Directory.GetCurrentDirectory())
                           .AddJsonFile("appsettings.json", optional: false, reloadOnChange: true)
                .AddEnvironmentVariables();

            return builder.Build();
        }

        private static DbContextOptions<OrderContext> GetDBOptions()
        {
            IConfiguration Configuration = GetBasicConfiguration();
            var migrationsAssembly = typeof(Program).GetTypeInfo().Assembly.GetName().Name;
            var connectionString = Configuration["ConnectionString"];

            var optionsBuilder = new DbContextOptionsBuilder<OrderContext>()
                .UseSqlite(connectionString,
                    sqliteOptionsAction: sqlOptions =>
                    {
                        sqlOptions.MigrationsAssembly(migrationsAssembly);
                    });

            return optionsBuilder.Options;
        }
    }
}
