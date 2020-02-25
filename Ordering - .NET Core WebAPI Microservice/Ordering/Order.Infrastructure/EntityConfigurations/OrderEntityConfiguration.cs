using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Metadata.Builders;
using System;
using System.Collections.Generic;
using System.Text;
using Ordering.Domain.Models.OrderAggregate;

namespace Ordering.Infrastructure.EntityConfigurations
{
    internal class OrderEntityConfiguration : EntityTypeConfiguration<Order>
    {
        public override void Configure(EntityTypeBuilder<Order> configuration)
        {
            base.Configure(configuration);

            configuration.Property(p => p.Id)
                .HasColumnType("varchar(36)")
                .IsRequired();

            configuration.Property(o => o.ProductId)
                .HasColumnType("varchar(36)")
                .IsRequired();

            configuration.Property(o => o.OrderDate)
                .HasColumnType("varchar(30)")
                .IsRequired();

            configuration.Property(o => o.Description)
                .HasColumnType("varchar(255)")
                .IsRequired();

            configuration.HasOne(p => p.OrderProduct)
                .WithMany()
                .HasForeignKey(o => o.ProductId);
        }
    }
}
